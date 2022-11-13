from __future__ import absolute_import
from __future__ import division
from __future__ import print_function
import json
import requests
import cv2
import numpy as np
import facenet
import detect_face
import os
import time
import pickle
from PIL import Image
import tensorflow.compat.v1 as tf
from flask import Flask, Response, jsonify, session, request, url_for
import threading
from flask_mysqldb import MySQL
from flask_cors import CORS, cross_origin
from datetime import datetime
from preprocess import preprocesses
import sys
from classifier import training

app = Flask(__name__)

app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'new_recogu'
app.config['CORS_HEADERS'] = 'Content-Type'

mysql = MySQL(app)



cors = CORS(app, resources={r"/get": {"origins": "http://localhost:port"}})


class cperson():
    def __init__(self):
        self.id = 0

person = cperson()

lock = threading.Lock()
os.environ['NO_PROXY'] = 'localhost'
@app.route('/get', methods = ['GET'])
def get():
    # requests.put('https://localhost:8000/aw', data="aw")
    cursor = mysql.connection.cursor()
    cursor.execute('''SELECT * FROM gatelog WHERE userID = 202200000''')
    data = cursor.fetchall()
    cursor.close()
    now = datetime.datetime.now()
    today_entry = now.replace(hour=7, minute=0, second=0, microsecond=0)
    today_exit = now.replace(hour=15, minute=0, second=0, microsecond=0)
    for row in data:
        time_entry = row[2]
        time_exit = row[3]

        

    
    # for row in data:
    #     dictionary = {
    #         "id": row[0],
    #         "fname": row[1],
    #         "mname": row[2],
    #         "lname": row[3],
    #     }
    # json_object = json.dumps(dictionary, indent = 4)
    # return Response(json_object, mimetype="application/json;")
    return str(now)


@app.route('/yawa')
@cross_origin(origin='localhost',headers=['Content- Type','Authorization'])
def yawa():
    # return add(wewew)
    dictionary = {"Data": "hello"}
    json_object = json.dumps(dictionary, indent = 4)
    return Response(json_object,  mimetype="application/json;")

@app.route('/gatelog')
@cross_origin(origin='localhost',headers=['Content- Type','Authorization'])
def gatelog():
    id = person.id
    now = datetime.now()
    today = now.strftime("%Y-%m-%d")
    time_now = now.strftime("%H:%M:%S")
    cur = mysql.connection.cursor()
    cur.execute('''SELECT * FROM gatelog WHERE userID = %s AND date = %s''', (id, today))
    r = cur.fetchone()

    if r == None:
        cur.execute(''' INSERT INTO gatelog ( userID, date, entry_time ) VALUES ( %s , %s, %s) ''', (id, today, time_now))
        mysql.connection.commit()
        mes = id
    else:
        mes = "ALREADY HAVE DATA"

    dictionary = {"Data": "Status:200"}
    json_object = json.dumps(dictionary, indent = 4)
    return Response(json_object,  mimetype="application/json;")

    

@app.route('/add/<userID>')
def add(userID):
    cur = mysql.connection.cursor()
    # cur.execute( '''SELECT * FROM gatelog WHERE = %s ''', (userID))
    # data = cur.fetchall()
    # for row in data:
    #     entry_time = row[0]
    now = datetime.now()
    today = now.strftime('%Y-%m-%d %H:%M:%S')
    cur.execute( '''INSERT INTO gatelog ( userID, time_entry ) VALUES ( %s, %s )''', (userID, today))
    mysql.connection.commit()
    return str(userID)





@app.route('/stream', methods=['GET'])
@cross_origin(origin='localhost',headers=['Content- Type','Authorization'])
def stream():
    return Response(generate(), mimetype = "multipart/x-mixed-replace; boundary=frame")

def generate():
    global lock

    video= 0
    modeldir = './model/20180402-114759.pb'
    classifier_filename = './class/classifier.pkl'
    npy='./npy'
    train_img="./train_img"
    with tf.Graph().as_default():
        gpu_options = tf.GPUOptions(per_process_gpu_memory_fraction=0.6)
        sess = tf.Session(config=tf.ConfigProto(gpu_options=gpu_options, log_device_placement=False))
        with sess.as_default():
            pnet, rnet, onet = detect_face.create_mtcnn(sess, npy)
            minsize = 30  # minimum size of face
            threshold = [0.7,0.8,0.8]  # three steps's threshold
            factor = 0.709  # scale factor
            margin = 44
            batch_size =100 #1000
            image_size = 182
            input_image_size = 160
            HumanNames = os.listdir(train_img)
            HumanNames.sort()
            print('Loading Model')
            facenet.load_model(modeldir)
            images_placeholder = tf.get_default_graph().get_tensor_by_name("input:0")
            embeddings = tf.get_default_graph().get_tensor_by_name("embeddings:0")
            phase_train_placeholder = tf.get_default_graph().get_tensor_by_name("phase_train:0")
            embedding_size = embeddings.get_shape()[1]
            classifier_filename_exp = os.path.expanduser(classifier_filename)
            with open(classifier_filename_exp, 'rb') as infile:
                (model, class_names) = pickle.load(infile,encoding='latin1')

            vc = cv2.VideoCapture(video, cv2.CAP_DSHOW)
            vc.open(0)

            if vc.isOpened():
                rval, frame = vc.read()
            else:
                rval = False
            
            while rval:

                with lock:

                    rval, frame = vc.read()

                    if frame is None:
                        continue


                    timer =time.time()
                    if frame.ndim == 2:
                        frame = facenet.to_rgb(frame)
                    bounding_boxes, _ = detect_face.detect_face(frame, minsize, pnet, rnet, onet, threshold, factor)
                    faceNum = bounding_boxes.shape[0]
                    if faceNum > 0:
                        det = bounding_boxes[:, 0:4]
                        img_size = np.asarray(frame.shape)[0:2]
                        cropped = []
                        scaled = []
                        scaled_reshape = []
                        for i in range(faceNum):
                            emb_array = np.zeros((1, embedding_size))
                            xmin = int(det[i][0])
                            ymin = int(det[i][1])
                            xmax = int(det[i][2])
                            ymax = int(det[i][3])
                            try:
                                # inner exception
                                if xmin <= 0 or ymin <= 0 or xmax >= len(frame[0]) or ymax >= len(frame):
                                    print('Face is very close!')
                                    continue
                                cropped.append(frame[ymin:ymax, xmin:xmax,:])
                                cropped[i] = facenet.flip(cropped[i], False)
                                scaled.append(np.array(Image.fromarray(cropped[i]).resize((image_size, image_size))))
                                scaled[i] = cv2.resize(scaled[i], (input_image_size,input_image_size),
                                                        interpolation=cv2.INTER_CUBIC)
                                scaled[i] = facenet.prewhiten(scaled[i])
                                scaled_reshape.append(scaled[i].reshape(-1,input_image_size,input_image_size,3))
                                feed_dict = {images_placeholder: scaled_reshape[i], phase_train_placeholder: False}
                                emb_array[0, :] = sess.run(embeddings, feed_dict=feed_dict)
                                predictions = model.predict_proba(emb_array)
                                best_class_indices = np.argmax(predictions, axis=1)
                                best_class_probabilities = predictions[np.arange(len(best_class_indices)), best_class_indices]
                                if best_class_probabilities>0.60:
                                    cv2.rectangle(frame, (xmin, ymin), (xmax, ymax), (0, 255, 0), 2)    #boxing face
                                    for H_i in HumanNames:
                                        if HumanNames[best_class_indices[0]] == H_i:
                                            result_names = HumanNames[best_class_indices[0]]
                                            print("Predictions : [ name: {} , accuracy: {:.3f} ]".format(HumanNames[best_class_indices[0]],best_class_probabilities[0]))
                                            cv2.rectangle(frame, (xmin, ymin-20), (xmax, ymin-2), (0, 255,255), -1)
                                            cv2.putText(frame, result_names, (xmin,ymin-5), cv2.FONT_HERSHEY_COMPLEX_SMALL,
                                                        1, (0, 0, 0), thickness=1, lineType=1)
                                            person.id = result_names
                                            yield(message())


                                            

                                            
                                else :
                                    cv2.rectangle(frame, (xmin, ymin), (xmax, ymax), (0, 255, 0), 2)
                                    cv2.rectangle(frame, (xmin, ymin-20), (xmax, ymin-2), (0, 255,255), -1)
                                    cv2.putText(frame, "?", (xmin,ymin-5), cv2.FONT_HERSHEY_COMPLEX_SMALL,
                                                        1, (0, 0, 0), thickness=1, lineType=1)
                            except:   
                                
                                print("error")
                    
                    endtimer = time.time()
                    fps = 1/(endtimer-timer)
                    cv2.rectangle(frame,(15,30),(135,60),(0,255,255),-1)
                    cv2.putText(frame, "fps: {:.2f}".format(fps), (20, 50),cv2.FONT_HERSHEY_SIMPLEX, 0.7, (0, 0, 0), 2)
                    (flag, encodedImage) = cv2.imencode(".jpg", frame)

                    if not flag:
                        continue

                yield(b'--frame\r\n' b'Content-Type: image/jpeg\r\n\r\n' + bytearray(encodedImage) + b'\r\n')
            
            vc.release()


@app.route('/data_process')
@cross_origin(origin='localhost',headers=['Content- Type','Authorization'])
def data_process():
    input_datadir = './train_img'
    output_datadir = './aligned_img'



    obj=preprocesses(input_datadir,output_datadir)
    nrof_images_total,nrof_successfully_aligned=obj.collect_data()

    print('Total number of images: %d' % nrof_images_total)
    print('Number of successfully aligned images: %d' % nrof_successfully_aligned)


    dictionary = {"Data": "Training...."}
    json_object = json.dumps(dictionary, indent = 4)
    return Response(json_object,  mimetype="application/json;")

@app.route('/train')
@cross_origin(origin='localhost',headers=['Content- Type','Authorization'])
def train():
    datadir = './aligned_img'
    modeldir = './model/20180402-114759.pb'
    #modeldir = './model/20170511-185253.pb'
    classifier_filename = './class/classifier.pkl'
    print ("Training Start")
    obj=training(datadir,modeldir,classifier_filename)
    get_file=obj.main_train()
    print('Saved classifier model to file "%s"' % get_file)
    print("All done")

    dictionary = {"Data": "SUCCESS: Data Trained!"}
    json_object = json.dumps(dictionary, indent = 4)
    return Response(json_object,  mimetype="application/json;")




@app.route('/message')
@cross_origin(origin='localhost',headers=['Content- Type','Authorization'])
def message():
    dictionary = {"Data": person.id}
    json_object = json.dumps(dictionary, indent = 4)

    return Response(json_object,  mimetype="application/json;")









if __name__ == '__main__':
   host = "localhost"
   port = 8000
   debug = True
   options = None
   app.run(host, port, debug, options)
            




    
            

