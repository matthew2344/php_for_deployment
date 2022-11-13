<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = 'error404';
$route['translate_uri_dashes'] = FALSE;

// RECOGU EXPLICIT ROUTES [START]
// 
// [LOGIN ROUTES] -> LINE 81-86
// *LOGIN FORM -> 83
// 
// [ADMIN ROUTES] -> LINE 88-132
// *ADMIN NAV LINKS -> 90
// *ADMIN UPDATE PROFILE -> 98
// *ADMIN DELETE SELF -> 104
// *ADMIN MANAGE STUDENT MODULE -> 107
// *ADMIN MANAGE TEACHER MODULE -> 115
// *ADMIN MANAGE STAFF MODULE -> 123
// 
// [STUDENT ROUTES] -> LINE 135-148
// *STUDENT NAV LINK -> 137
// *STUDENT FUNCTIONS -> 142
// 
// [TEACHER ROUTES] -> LINE 151-164
// *TEACHER NAV LINK -> 153
// *TEACHER FUNCTIONS -> 158
// 
// [STAFF ROUTES] ---[WORK IN PROGRESS]---
// 
// [END] EXPLICIT ROUTES

// LOGIN ROUTES [START]

    // LOGIN FORM
    $route['login_authentication'] = 'Login/auth';

// LOGIN ROUTES [END]

// ADMIN ROUTES [START]

    // ADMIN NAV LINKS
    $route['Admin_student'] = 'Admin/student';
    $route['Admin_teacher'] = 'Admin/teacher';
    $route['Admin_staff'] = 'Admin/staff';
    $route['Admin_profile'] = 'Admin/profile';
    $route['Admin_edit'] = 'Admin/edit_profile';
    $route['Admin_dashboard'] = 'Admin';

    // ADMIN UPDATE PROFILE
    $route['Admin_update/(:num)'] = 'Admin/update_profile/$1';
    $route['Admin_email/(:num)'] = 'Admin/update_email/$1';
    $route['Admin_password/(:num)'] = 'Admin/update_password/$1';
    $route['Admin_avatar/(:num)'] = 'Admin/update_avatar/$1';

    // ADMIN DELETE SELF
    $route['Admin_delete/(:num)'] = 'Admin/delete_user/$1';

    // ADMIN MANAGE STUDENT MODULE
    $route['Create_student'] = 'Admin/create_student';
    $route['Search_student'] = 'Admin/search_student';
    $route['View_student/(:num)'] = 'Admin/view_student/$1';
    $route['Edit_student/(:num)'] = 'Admin/edit_student/$1';
    $route['Update_student/(:num)'] = 'Admin/update_student/$1';
    $route['Delete_student/(:num)'] = 'Admin/delete_student/$1';
    
    // ADMIN MANAGE TEACHER MODULE
    $route['Create_teacher'] = 'Admin/create_teacher';
    $route['Search_teacher'] = 'Admin/search_teacher';
    $route['View_teacher/(:num)'] = 'Admin/view_teacher/$1';
    $route['Edit_teacher/(:num)'] = 'Admin/edit_teacher/$1';
    $route['Update_teacher/(:num)'] = 'Admin/update_teacher/$1';
    $route['Delete_teacher/(:num)'] = 'Admin/delete_teacher/$1';

    // ADMIN MANAGE STAFF MODULE
    $route['Create_staff'] = 'Admin/create_staff';
    $route['Search_staff'] = 'Admin/search_staff';
    $route['View_staff/(:num)'] = 'Admin/view_staff/$1';
    $route['Edit_staff/(:num)'] = 'Admin/edit_staff/$1';
    $route['Update_staff/(:num)'] = 'Admin/update_staff/$1';
    $route['Delete_staff/(:num)'] = 'Admin/delete_staff/$1';


// ADMIN ROUTES [END]


// STUDENT ROUTES [START]

    // STUDENT NAV LINK
    $route['Student_dashboard'] = 'Student';
    $route['Student_profile'] = 'Student/profile';
    $route['Student_edit'] = 'Student/edit_profile';
    
    // STUDENT FUNCTIONS
    $route['Student_avatar/(:num)'] = 'Student/update_avatar/$1';
    $route['Student_update/(:num)'] = 'Student/update_profile/$1';
    $route['Student_password/(:num)'] = 'Student/update_password/$1';
    

// STUDENT ROUTES [END]


// TEACHER ROUTES [START]

    // TEACHER NAV LINK
    $route['Teacher_dashboard'] = 'Teacher';
    $route['Teacher_profile'] = 'Teacher/profile';
    $route['Teacher_edit'] = 'Teacher/edit_profile';
    
    // TEACHER FUNCTIONS
    $route['Teacher_avatar/(:num)'] = 'Teacher/update_avatar/$1';
    $route['Teacher_update/(:num)'] = 'Teacher/update_profile/$1';
    $route['Teacher_password/(:num)'] = 'Teacher/update_password/$1';
    

// TEACHER ROUTES [END]

// REGISTER ROUTES [START]

    $route['New_user'] = 'Register/new_user';

// REGISTER ROUTES [END]
