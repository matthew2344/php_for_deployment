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
from flask import Flask, Response, jsonify, request
import threading
from flask_mysqldb import MySQL
from flask_cors import CORS, cross_origin
from datetime import datetime
from preprocess import preprocesses
import sys
import base64
import io
from classifier import training
from io import StringIO, BytesIO
from binascii import a2b_base64
from PIL import Image
from werkzeug.utils import secure_filename
import uuid



app = Flask(__name__)


lock = threading.Lock()
global capture, greyimage, facerecog, lol
capture = 0
greyimage = 0
facerecog = 0
video= 0
lol = 0 

global person, accuracy 
person = []
accuracy = []






@app.route('/')
def home():
    return "Flask Railway app."


@app.route('/upload_images/<userID>', methods=['POST'])
def upload_image(userID):
    if request.method == 'POST':
        UPLOAD_PATH = './train_img/'+str(userID)+'/'
        isExist = os.path.exists(UPLOAD_PATH)
        if not isExist:
            os.makedirs(UPLOAD_PATH)

        uri = request.form['image']
        the_image = readb64(uri)
        randomName = str(uuid.uuid4())
        filename = randomName+".jpg"
        os.chdir(UPLOAD_PATH)

        cv2.imwrite(filename, the_image)
        # completeName = os.path.join(UPLOAD_PATH, filename)
        # with open(completeName, "wb") as f:
        #     f.write(the_image)

        return ''


        return ""

    return ""


@app.route('/upload_face/<userID>', methods=['POST'])
def upload_face(userID):
    if request.method == 'POST':
        files = request.files.getlist("file[]")
        UPLOAD_PATH = './train_img/'+str(userID)+'/'
        isExist = os.path.exists(UPLOAD_PATH)
        if not isExist:
            os.makedirs(UPLOAD_PATH)

        for file in files:
            file.save(os.path.join(UPLOAD_PATH, file.filename))

        return str(files)

    return ""



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




@app.route('/image',  methods=['POST', 'GET'])
@cross_origin(origin='localhost',headers=['Content- Type','Authorization'])
def image():
    global lol, s, person, accuracy
    lol = lol + 1
    # global pnet, rnet, onet, minsize, threshold, factor, margin, batch_size
    # global image_size, input_image_size, HumanNames, images_placeholder
    # global embeddings, phase_train_placeholder, embedding_size, classifier_filename_exp
    # global model, class_names, sess



    if request.method == 'POST':
        s = request.form['image']
        return jsonify(request.form['image'])
    
    elif request.method=='GET':
        with open(classifier_filename_exp, 'rb') as infile:
            (model, class_names) = pickle.load(infile,encoding='latin1')
            
        person = []
        accuracy = []
        img = readb64(s)
        # cv2.imshow('DECODED IMAGE',img)
        # cv2.waitKey(0)
        frame = img
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
                    if best_class_probabilities>0.20:
                        cv2.rectangle(frame, (xmin, ymin), (xmax, ymax), (0, 255, 0), 2)    #boxing face
                        for H_i in HumanNames:
                            if HumanNames[best_class_indices[0]] == H_i:
                                result_names = HumanNames[best_class_indices[0]]
                                print("Predictions : [ name: {} , accuracy: {:.3f} ]".format(HumanNames[best_class_indices[0]],best_class_probabilities[0]))
                                cv2.rectangle(frame, (xmin, ymin-20), (xmax, ymin-2), (0, 255,255), -1)
                                cv2.putText(frame, result_names, (xmin,ymin-5), cv2.FONT_HERSHEY_COMPLEX_SMALL,
                                            1, (0, 0, 0), thickness=1, lineType=1)                                
                                person.append(result_names)
                                string_temp = "{:.3f}".format(best_class_probabilities[0])
                                accuracy.append(string_temp)
                                
        
                    else :
                        cv2.rectangle(frame, (xmin, ymin), (xmax, ymax), (0, 255, 0), 2)
                        cv2.rectangle(frame, (xmin, ymin-20), (xmax, ymin-2), (0, 255,255), -1)
                        cv2.putText(frame, "?", (xmin,ymin-5), cv2.FONT_HERSHEY_COMPLEX_SMALL,
                                            1, (0, 0, 0), thickness=1, lineType=1)
                except:
        
                    print("error")

        fer, encodedImage = cv2.imencode(".jpg", frame)
        thisimage = encodedImage.tobytes()
        # A = (b'--frame\r\n' b'Content-Type: image/jpeg\r\n\r\n' + bytearray(encodedImage) + b'\r\n')
                        
        return Response(thisimage,mimetype = "image/jpeg")
        # return jsonify(thisimage)


    return jsonify(wow = "amazing")

@app.route('/show_person')
@cross_origin(origin='*',headers=['Content- Type','Authorization'])
def show_person():
    global person, accuracy

    dictionary = {"userid": person, "accuracy": accuracy}
    json_object = json.dumps(dictionary, indent = 4)
    return Response(json_object,  mimetype="application/json;")




try:
    os.mkdir('./shots')
except OSError as error:
    pass




@app.route('/upload_file', methods=['GET', 'POST'])
def uploade_file():
    if request.method == "POST":
        if 'webcam' not in request.files:
            return 'there is no file in form!'
        file = request.files['webcam']
        path = os.path.join('./shots', file.filename)
        file.save(path)
        return path

        return 'ok'
    return ''



def readb64(uri):
   encoded_data = uri.split(',')[1]
   nparr = np.frombuffer(base64.b64decode(encoded_data), np.uint8)
   img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)
   return img


if __name__ == '__main__':

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


   host = "localhost"
   port = 8000
   debug = True
   options = None
   app.run(host, port, debug, options)
            