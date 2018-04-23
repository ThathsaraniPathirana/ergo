<?php
use App\Http\Middleware\SessionCheck;
use App\Http\Middleware\AuthCheck;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/landing', function () {
//     return view('landing');
// });

/*Route::get('/addmember',function(){
	return view('addmember');
});*/
/*Route::get('/getdata','GuzzleController@getRemoteData');
Route::get('editprofile',function(){
	return view('profile');
});
*/
Route::get('/getdata1', function () {
   return view('getdata1');
});

//Route::post('/addmember', 'AdminController@getLoginData');

// routes in saras part 
// Route::get('/viewProjects', function () {
//     return view('viewProjects');
// });

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/viewmember', function () {
//     return view('viewmember');
// });

// Route::get('/createProjects', function () {
//     return view('createProjects');
// });

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/events', function () {
    return view('events');
});

Route::get('/milestones', function () {
    return view('milestones');
});

Route::get('/tasks', function () {
    return view('tasks');
});

Route::get('/projects', function () {
    return view('projects');
});
// Route::get('/addmember', function () {
//     return view('addmember');
// });

//user routes

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(SessionCheck::class);

Route::get('/addmember','AdminController@loadmember');

Route::get('/landing','AdminController@loading');

Route::post('/adminRegister','AdminController@getRegistration');

Route::post('/adminLogin','AdminController@getLoginData');

Route::get('/viewUser','AdminController@viewUserData');

Route::post('/viewsubmitUser','AdminController@viewsubmitUser')->middleware(AuthCheck::class);

Route::get('/viewAllUsers','AdminController@viewAllUsers')->middleware(AuthCheck::class);

Route::get('/logout','LogoutController@logout');


//project route

Route::post('/submitProjects','projectController@getProjectData');

Route::get('/createProjects','projectController@createProject');
// Route::get('/createProjects', function () {
//     return view('createProjects');
// })->middleware(SessionCheck::class);

Route::get('viewProjects','projectController@viewProjects');
// Route::get('/viewProjects',function(){
//     return view('viewProjects');
// });
Route::post('viewProject','projectController@viewProject');


// task routes
Route::post('/createTasks','TaskController@createTasks');
// Route::get('/createTasks', function () {
//     return view('createTasks');
// });

Route::post('/submitTask','TaskController@getTaskData');

Route::post('/viewAllTasks','TaskController@viewAllTasks');

Route::get('/viewTasks','TaskController@viewMyTask');

// Route::get('/viewTasks',function(){
//     return view('viewTasks');
// });

//event routes

Route::get('/createEvent','EventController@createEvent');

Route::post('/submitEvent','EventController@submitEvent');



//Route::get('profile','UserController@profile');
//Route::post('profile','UserController@update_avatar');
//Route::get('viewProjects','GuzzleController@getProjects');
//Route::get('tasks','GuzzleController@getTasks');
//Route::get('milestones','GuzzleController@getMilestones');


?>