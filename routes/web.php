<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignSubjectController;
use App\Http\Controllers\AssignTeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassTimetableController;
use App\Http\Controllers\CommunicateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExaminationsController;
use App\Http\Controllers\FeesCollectionController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;












Route::get('/',[AuthController::class,'login']);
Route::post('login',[AuthController::class,'auth_login']);
Route::get('logout',[AuthController::class,'logout']);
Route::get('forgot_password',[AuthController::class,'forgotpassword']);
Route::post('forgot_password',[AuthController::class,'postforgotpassword']);

Route::group(['middleware'=>'common'],function(){
    Route::get('chat', [ChatController::class, 'chat']);
});

Route::group(['middleware'=>'admin'],function(){
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('admin/admin/list', [AdminController::class, 'list']);
    Route::get('admin/admin/add', [AdminController::class, 'add']);
    Route::post('admin/admin/add', [AdminController::class, 'insert'])->name('admin.insert');
    Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('admin/admin/edit/{id}', [AdminController::class, 'update']);
    Route::get('admin/admin/delete/{id}', [AdminController::class, 'delete']);

    //student
    Route::get('admin/student/list', [StudentController::class, 'list']);
    Route::get('admin/student/add', [StudentController::class, 'add']);
    Route::post('admin/student/add', [StudentController::class, 'insert']);
    Route::get('admin/student/edit/{id}', [StudentController::class, 'edit']);
    Route::post('admin/student/edit/{id}', [StudentController::class, 'update']);
    Route::get('admin/student/delete/{id}', [StudentController::class, 'delete']);

    Route::post('admin/student/export-list', [StudentController::class, 'export_list']);

    //parent
    Route::get('admin/parent/list', [ParentController::class, 'list']);
    Route::get('admin/parent/add', [ParentController::class, 'add']);
    Route::post('admin/parent/add', [ParentController::class, 'insert']);
    Route::get('admin/parent/edit/{id}', [ParentController::class, 'edit']);
    Route::post('admin/parent/edit/{id}', [ParentController::class, 'update']);
    Route::get('admin/parent/delete/{id}', [ParentController::class, 'delete']);
    Route::get('admin/parent/my-student/{id}', [ParentController::class, 'my_student']);
    Route::get('admin/parent/assign_student_parent/{student_id}/{parent_id}', [ParentController::class, 'assign_student_parent']);
    Route::get('admin/parent/assign_student_parent_delete/{student_id}', [ParentController::class, 'assign_student_parent_delete']);

    //teacher
    Route::get('admin/teacher/list', [TeacherController::class, 'list']);
    Route::get('admin/teacher/add', [TeacherController::class, 'add']);
    Route::post('admin/teacher/add', [TeacherController::class, 'insert']);
    Route::get('admin/teacher/edit/{id}', [TeacherController::class, 'edit']);
    Route::post('admin/teacher/edit/{id}', [TeacherController::class, 'update']);
    Route::get('admin/teacher/delete/{id}', [TeacherController::class, 'delete']);
    Route::get('admin/teacher/assign_class/{id}', [UserController::class, 'assign_class']);
    Route::post('admin/teacher/assign_class/{id}', [TeacherController::class, 'post_assign_class']);
    Route::get('admin/teacher/assign_class_delete/{id}', [TeacherController::class, 'assign_class_delete']);

    //class
    Route::get('admin/class/list', [ClassController::class, 'list']);
    Route::get('admin/class/add', [ClassController::class, 'add']);
    Route::post('admin/class/add', [ClassController::class, 'insert']);
    Route::get('admin/class/edit/{id}', [ClassController::class, 'edit']);
    Route::post('admin/class/edit/{id}', [ClassController::class, 'update']);
    Route::get('admin/class/delete/{id}', [ClassController::class, 'delete']);

    //subject
    Route::get('admin/subject/list', [SubjectController::class, 'list']);
    Route::get('admin/subject/add', [SubjectController::class, 'add']);
    Route::post('admin/subject/add', [SubjectController::class, 'insert']);
    Route::get('admin/subject/edit/{id}', [SubjectController::class, 'edit']);
    Route::post('admin/subject/edit/{id}', [SubjectController::class, 'update']);
    Route::get('admin/subject/delete/{id}', [SubjectController::class, 'delete']);

    //assign_subject
    Route::get('admin/assign_subject/list', [AssignSubjectController::class, 'list']);
    Route::get('admin/assign_subject/add', [AssignSubjectController::class, 'add']);
    Route::post('admin/assign_subject/add', [AssignSubjectController::class, 'insert']);
    Route::get('admin/assign_subject/edit/{id}', [AssignSubjectController::class, 'edit']);
    Route::post('admin/assign_subject/edit/{id}', [AssignSubjectController::class, 'update']);
    Route::get('admin/assign_subject/delete/{id}', [AssignSubjectController::class, 'delete']);
    Route::get('admin/assign_subject/edit_single/{id}', [AssignSubjectController::class, 'edit_single']);
    Route::post('admin/assign_subject/edit_single/{id}', [AssignSubjectController::class, 'update_single']);

    //assign_teacher
    Route::get('admin/assign_teacher/list', [AssignTeacherController::class, 'list']);
    Route::get('admin/assign_teacher/add', [AssignTeacherController::class, 'add']);
    Route::post('admin/assign_teacher/add', [AssignTeacherController::class, 'insert']);
    Route::get('admin/assign_teacher/edit/{id}', [AssignTeacherController::class, 'edit']);
    Route::post('admin/assign_teacher/edit/{id}', [AssignTeacherController::class, 'update']);
    Route::get('admin/assign_teacher/delete/{id}', [AssignTeacherController::class, 'delete']);
    Route::get('admin/assign_teacher/edit_single/{id}', [AssignTeacherController::class, 'edit_single']);
    Route::post('admin/assign_teacher/edit_single/{id}', [AssignTeacherController::class, 'update_single']);

    //class_timetable
    Route::get('admin/class_timetable/list', [ClassTimetableController::class, 'list']);
    Route::post('admin/class_timetable/get-subject', [ClassTimetableController::class, 'getSubject']);
    Route::post('admin/class_timetable/add', [ClassTimetableController::class, 'insertUpdate']);

    //exams
    Route::get('admin/exams/list', [ExaminationsController::class, 'list']);
    Route::get('admin/exams/add', [ExaminationsController::class, 'add']);
    Route::post('admin/exams/add', [ExaminationsController::class, 'insert']);
    Route::get('admin/exams/edit/{id}', [ExaminationsController::class, 'edit']);
    Route::post('admin/exams/edit/{id}', [ExaminationsController::class, 'update']);
    Route::get('admin/exams/delete/{id}', [ExaminationsController::class, 'delete']);

    //exam_schedule
    Route::get('admin/exams/exam_schedule', [ExaminationsController::class, 'exam_schedule']);
    Route::post('admin/exams/exam_schedule_insert',[ExaminationsController::class, 'exam_schedule_update']);

    //marks-register
    Route::get('admin/exams/marks-register', [ExaminationsController::class, 'marks_register']);
    Route::post('admin/exams/submit-marks-register',[ExaminationsController::class, 'submit_marks_register']);
    Route::post('admin/exams/single-submit-marks-register',[ExaminationsController::class, 'single_submit_marks_register']);
    Route::get('admin/exam-result/print', [ExaminationsController::class, 'examResultPrint']);


    //marks-grade
    Route::get('admin/exams/marks-grade', [ExaminationsController::class, 'marks_grade']);
    Route::get('admin/exams/marks-grade/add', [ExaminationsController::class, 'add_marks_grade']);
    Route::post('admin/exams/marks-grade/add', [ExaminationsController::class, 'insert_marks_grade']);
    Route::get('admin/exams/marks-grade/edit/{id}', [ExaminationsController::class, 'edit_marks_grade']);
    Route::post('admin/exams/marks-grade/edit/{id}', [ExaminationsController::class, 'update_marks_grade']);
    Route::get('admin/exams/marks-grade/delete/{id}', [ExaminationsController::class, 'delete_marks_grade']);

    //Student Attendance
    Route::get('admin/attendance/student', [AttendanceController::class, 'studentAttendance']);
    Route::post('admin/attendance/student/save', [AttendanceController::class, 'SavestudentAttendance']);
    Route::get('admin/attendance/report', [AttendanceController::class, 'AttendanceReport']);
    Route::post('admin/attendance/export-report', [AttendanceController::class, 'AttendanceReportExport']);

    //noticeboard
    Route::get('admin/communicate/noticeboard', [CommunicateController::class, 'NoticeBoard']);
    Route::get('admin/communicate/noticeboard/add', [CommunicateController::class, 'NoticeBoardAdd']);
    Route::post('admin/communicate/noticeboard/add', [CommunicateController::class, 'NoticeBoardInsert']);
    Route::get('admin/communicate/noticeboard/edit/{id}', [CommunicateController::class, 'edit']);
    Route::post('admin/communicate/noticeboard/edit/{id}', [CommunicateController::class, 'update']);
    Route::get('admin/communicate/noticeboard/delete/{id}', [CommunicateController::class, 'delete']);

    //send-email
    Route::get('admin/communicate/send-email', [CommunicateController::class, 'sendEmail']);
    Route::post('admin/communicate/send-email', [CommunicateController::class, 'UserSendEmail']);
    //ajax to get users
    Route::get('admin/communicate/get_users', [CommunicateController::class, 'getUsers']);

    //homeworkhomework
    Route::get('admin/homework/homework', [HomeworkController::class, 'homework']);
    Route::get('admin/homework/homework-report', [HomeworkController::class, 'homeworkReport']);
    Route::get('admin/homework/homework/add', [HomeworkController::class, 'add']);
    Route::post('admin/homework/get_subject_ajax', [HomeworkController::class, 'get_subject_ajax']);
    Route::post('admin/homework/homework/add', [HomeworkController::class, 'insert']);
    Route::get('admin/homework/homework/edit/{id}', [HomeworkController::class, 'edit']);
    Route::post('admin/homework/homework/edit/{id}', [HomeworkController::class, 'update']);
    Route::get('admin/homework/homework/delete/{id}', [HomeworkController::class, 'delete']);
    Route::get('admin/homework/homework/submitted/{id}', [HomeworkController::class, 'Submitted']);

    //fees collection
    Route::get('admin/fees-collection/collect-fees', [FeesCollectionController::class, 'collect_fees']);
    Route::get('admin/fees-collection/collect-fees/add/{id}', [FeesCollectionController::class, 'add_fees']);
    Route::post('admin/fees-collection/collect-fees/add/{id}', [FeesCollectionController::class, 'add_fees_insert']);
    Route::get('admin/fees-collection/fees-collection-report', [FeesCollectionController::class, 'collection_report']);
    Route::post('admin/fees-collection/export-fees-collection-report', [FeesCollectionController::class, 'export_collection_report']);

    //change_password
    Route::get('admin/change_password', [UserController::class, 'change_password']);
    Route::post('admin/change_password', [UserController::class, 'post_change_password']);

    //admin/my-account
    Route::get('admin/my-account', [UserController::class, 'my_account']);
    Route::post('admin/my-account', [UserController::class, 'post_my_account_admin']);

    //settings
    Route::get('admin/my-settings', [UserController::class, 'my_settings']);
    Route::post('admin/my-settings', [UserController::class, 'post_my_settings']);

});

Route::group(['middleware'=>'teacher'],function(){
    Route::get('teacher/dashboard', [DashboardController::class, 'dashboard']);

    //change_password
    Route::get('teacher/change_password', [UserController::class, 'change_password']);
    Route::post('teacher/change_password', [UserController::class, 'post_change_password']);

    //my-class-subject
    Route::get('teacher/my-class-subject', [AssignTeacherController::class, 'MyClassSubject']);

    //my-students
    Route::get('teacher/my-students', [StudentController::class, 'MyStudent']);

    //timetable
    Route::get('teacher/my-class-subject/my-timetable/{class_id}/{subject_id}', [ClassTimetableController::class, 'MyTimetableTeacher']);
    Route::get('teacher/my-exam-timetable', [ExaminationsController::class, 'MyExamScheduleTeacher']);

    //marks-register
    Route::get('teacher/marks-register', [ExaminationsController::class, 'marks_registerT_teacher']);
    Route::post('teacher/submit-marks-register',[ExaminationsController::class, 'submit_marks_register']);
    Route::post('teacher/single-submit-marks-register',[ExaminationsController::class, 'single_submit_marks_register']);

    //Student Attendance
    Route::get('teacher/attendance/student', [AttendanceController::class, 'studentAttendanceTeacher']);
    Route::post('teacher/attendance/student/save', [AttendanceController::class, 'SavestudentAttendance']);
    Route::get('teacher/attendance/report', [AttendanceController::class, 'AttendanceReportTeacher']);

    //homeworkhomework
    Route::get('teacher/homework/homework', [HomeworkController::class, 'homework']);
    Route::get('teacher/homework/homework/add', [HomeworkController::class, 'add']);
    Route::post('teacher/homework/get_subject_ajax', [HomeworkController::class, 'get_subject_ajax']);
    Route::post('teacher/homework/homework/add', [HomeworkController::class, 'insert']);
    Route::get('teacher/homework/homework/edit/{id}', [HomeworkController::class, 'edit']);
    Route::post('teacher/homework/homework/edit/{id}', [HomeworkController::class, 'update']);
    Route::get('teacher/homework/homework/delete/{id}', [HomeworkController::class, 'delete']);
    Route::get('teacher/homework/homework/submitted/{id}', [HomeworkController::class, 'Submitted']);

    //my-calender
    Route::get('teacher/my-calender', [CalenderController::class, 'MyCalenderTeacher']);

    //teacher/my-account
    Route::get('teacher/my-account', [UserController::class, 'my_account']);
    Route::post('teacher/my-account', [UserController::class, 'post_my_account']);
});

Route::group(['middleware'=>'student'],function(){
    Route::get('student/dashboard', [DashboardController::class, 'dashboard']);
    //fee
    Route::get('student/fees-collection', [FeesCollectionController::class, 'add_fees_student']);
    Route::post('student/fees-collection', [FeesCollectionController::class, 'add_fees_insert_student']);

    Route::get('student/fees-payment-success', [FeesCollectionController::class, 'PaymentSuccess']);
    Route::get('student/fees-payment-cancel', [FeesCollectionController::class, 'PaymentCancel']);

    //subject
    Route::get('student/my-subject', [SubjectController::class, 'MySubject']);

    //timetable
    Route::get('student/my-timetable', [ClassTimetableController::class, 'MyTimetable']);
    Route::get('student/my-exam-timetable', [ExaminationsController::class, 'MyExamSchedule']);

    //my-calender
    Route::get('student/my-calender', [CalenderController::class, 'MyCalender']);

    //exam-result
    Route::get('student/exam-result', [ExaminationsController::class, 'examResult']);
    Route::get('student/exam-result/print', [ExaminationsController::class, 'examResultPrint']);

    //homework
    Route::get('student/my-homework', [HomeworkController::class, 'homeworkStudent']);
    Route::get('student/my-homework/submit-homework/{id}', [HomeworkController::class, 'homeworkSubmit']);
    Route::post('student/my-homework/submit-homework/{id}', [HomeworkController::class, 'homeworkSubmitInsert']);
    Route::get('student/submit-homework', [HomeworkController::class, 'homeworkSubmitList']);

    // my attendance
    Route::get('student/my-attendance', [AttendanceController::class, 'AttendanceReportStudent']);

    //my-noticeboard
    Route::get('student/my-noticeboard', [CommunicateController::class, 'MyNoticeBoardStudent']);

    //change_password
    Route::get('student/change_password', [UserController::class, 'change_password']);
    Route::post('student/change_password', [UserController::class, 'post_change_password']);

    //student/my-account
    Route::get('student/my-account', [UserController::class, 'my_account']);
    Route::post('student/my-account', [UserController::class, 'post_my_account_student']);
});

Route::group(['middleware'=>'parent'],function(){
    Route::get('parent/dashboard', [DashboardController::class, 'dashboard']);

    //my-student
    Route::get('parent/my-student', [ParentController::class, 'my_student_parent']);

    //admin/my-student/subject/'.$value->id
    Route::get('parent/my-student/subject/{student_id}', [SubjectController::class, 'ParentStudentSubject']);
    Route::get('parent/my-student/my-exam-timetable/{student_id}', [ExaminationsController::class, 'ParentStudentExam']);
    //exam result
    Route::get('parent/my-student/my-exam-result/{student_id}', [ExaminationsController::class, 'ParentStudentExamResult']);
    Route::get('parent/exam-result/print', [ExaminationsController::class, 'examResultPrint']);

    // my attendance
    Route::get('parent/my-student/attendance/{student_id}', [AttendanceController::class, 'ParentStudentAttendance']);

    //timetable
    Route::get('parent/my-student/subject/timetable/{class_id}/{subject_id}/{student_id}', [ClassTimetableController::class, 'MyTimetableParent']);

    //homework
    Route::get('parent/my-student/homework/{id}', [HomeworkController::class, 'homeworkParent']);
    Route::get('parent/my-student/homework-submitted/{id}', [HomeworkController::class, 'SubmithomeworkParent']);

    //Calender
    Route::get('parent/my-student/my-calender/{student_id}', [CalenderController::class, 'ParentStudentCalender']);

    //fee
    Route::get('parent/my-student/fee-collection/{student_id}', [FeesCollectionController::class, 'add_fees_parent']);
    Route::post('parent/my-student/fee-collection/{student_id}', [FeesCollectionController::class, 'add_fees_insert_parent']);

    Route::get('parent/fees-payment-success/{student_id}', [FeesCollectionController::class, 'PaymentSuccess']);
    Route::get('parent/fees-payment-cancel/{student_id}', [FeesCollectionController::class, 'PaymentCancel']);

    //change_password
    Route::get('parent/change_password', [UserController::class, 'change_password']);
    Route::post('parent/change_password', [UserController::class, 'post_change_password']);

    //parent/my-account
    Route::get('parent/my-account', [UserController::class, 'my_account']);
    Route::post('parent/my-account', [UserController::class, 'post_my_account_parent']);

});


Route::post('payments', [FeesCollectionController::class, 'payments']);
