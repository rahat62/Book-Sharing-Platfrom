<?php

namespace App\Http\Controllers\User;

use File;
use Helper;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Book_user;
use App\Models\BookCategory_user;
use App\Models\Author_user;
use App\Models\Language_user;
use DB;
use Auth;

class AddBookController extends Controller
{
    public function index()
    {
        $auth_id = Auth::id();

        $data['books'] = Book_user::join('book_categories', 'book_categories.id', '=', 'books.category_id')
            ->join('authors', 'authors.id', '=', 'books.author_id')
            ->select('books.*', 'book_categories.name as category_name', 'authors.name as author_name')
            ->where('books.created_by', $auth_id)
            ->where('books.valid', 1)
            ->get();
        
        return view('user.addBook.listData', $data);
    }

    public function create()
    {
        $data['categories'] = BookCategory_user::valid()->get();
        $data['authors'] = Author_user::valid()->get();
        $data['languages'] = Language_user::valid()->get();
        $data['book_id'] = Helper::bookIdGenerate();

        return view('user.addBook.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id'        => 'required',
            'title'          => 'required',
            'category_id'    => 'required',
            'summery'        => 'required',
            'number_of_page' => 'required',
            'author_id'      => 'required',
            'language_id'    => 'required',
            'book_thumb'     => 'required'
        ]);
        if ($validator->passes()) {
            $mainFile = $request->book_thumb;
            $imgPath = 'uploads/book';
            $uploadResponse = Helper::getUploadedFileName($mainFile, $imgPath, 450, 460);
            
            if ($uploadResponse['status'] == 1) {
                Book_user::create([
                    'book_id'        => Helper::bookIdGenerate(),
                    'title'          => $request->title,
                    'category_id'    => $request->category_id,
                    'summery'        => $request->summery,
                    'number_of_page' => $request->number_of_page,
                    'author_id'      => $request->author_id,
                    'language_id'    => $request->language_id,
                    'book_thumb'    => $uploadResponse['file_name'],
                ]);
                $output['messege'] = 'Book has been created';
                $output['msgType'] = 'success';
            } else {
                
                $output['messege'] = $uploadResponse['errors'];
                $output['msgType'] = 'danger';
            }
            return redirect()->back()->with($output);
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['categories'] = BookCategory_user::valid()->get();
        $data['authors'] = Author_user::valid()->get();
        $data['languages'] = Language_user::valid()->get();
        $data['book'] = Book_user::valid()->find($id);

        return view('user.addBook.update', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'          => 'required',
            'category_id'    => 'required',
            'summery'        => 'required',
            'number_of_page' => 'required',
            'author_id'      => 'required',
            'language_id'    => 'required',
            'book_thumb'     => 'required'
        ]);
        if ($validator->passes()) {
            $book = Book_user::find($id);
            if (isset($request->book_thumb)) {
                if ($request->book_thumb != $book->book_thumb) {
                    $mainFile = $request->book_thumb;
                    $imgPath = 'uploads/book';
                    $uploadResponse = Helper::getUploadedFileName($mainFile, $imgPath, 450, 460);
                    
                    if ($uploadResponse['status'] == 1) {
                        File::delete(public_path($imgPath.'/').$book->book_thumb);
                        File::delete(public_path($imgPath.'/thumb/').$book->book_thumb);
                        
                        Book_user::find($id)->update([
                            'title'          => $request->title,
                            'category_id'    => $request->category_id,
                            'summery'        => $request->summery,
                            'number_of_page' => $request->number_of_page,
                            'author_id'      => $request->author_id,
                            'language_id'    => $request->language_id,
                            'book_thumb'     => $uploadResponse['file_name']
                        ]);
                        $output['messege'] = 'Book has been updated';
                        $output['msgType'] = 'success';
                    } else {
                        $output['messege'] = $uploadResponse['errors'];
                        $output['msgType'] = 'danger';
                    }
                } else {
                    Book_user::find($id)->update([
                        'title'          => $request->title,
                        'category_id'    => $request->category_id,
                        'summery'        => $request->summery,
                        'number_of_page' => $request->number_of_page,
                        'author_id'      => $request->author_id,
                        'language_id'    => $request->language_id
                    ]);
                    $output['messege'] = 'Book has been updated';
                    $output['msgType'] = 'success';
                }
            } else {
                Book_user::find($id)->update([
                    'title'          => $request->title,
                    'category_id'    => $request->category_id,
                    'summery'        => $request->summery,
                    'number_of_page' => $request->number_of_page,
                    'author_id'      => $request->author_id,
                    'language_id'    => $request->language_id
                ]);
                $output['messege'] = 'Book has been updated';
                $output['msgType'] = 'success';
            }
            return redirect()->back()->with($output);
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book_user::valid()->find($id);
        File::delete(public_path('uploads/book/').$book->book_thumb);
        File::delete(public_path('uploads/book/thumb/').$book->book_thumb);
        Book_user::valid()->find($id)->delete();
    }

    public function assignTeacher(Request $request)
    {
        $data['course_id'] = $course_id = $request->id;
        $data['teachers'] = EduTeachers_Provider::valid()->get();
        $data['assigned_teachers'] = EduAssignCourseTeachers_Provider::valid()->where('course_id', $course_id)->get()->pluck('teacher_id')->toArray();
        return view('user.addBook.assignTeacher', $data);
    }
    public function assignTeacherAction(Request $request)
    {
        $data['course_id'] = $course_id = $request->id;
        $teachers_arr = $request->teachers;
        $validator = Validator::make($request->all(), [
            'teachers' => 'required',
        ]);

        if ($validator->passes()) {
            $old_teachers = EduAssignCourseTeachers_Provider::valid()->where('course_id', $course_id)->get()->keyBy('teacher_id')->all();

            $new_teacher_ids = array_filter($teachers_arr);
            if (!empty($old_teachers)) {
                foreach($old_teachers as $key => $oldValue) {
                    if(!in_array($key, $new_teacher_ids)) {
                        EduAssignCourseTeachers_Provider::find($oldValue->id)->delete();
                    }
                }
            }
            foreach($new_teacher_ids as $key => $teacher_id) 
            {
                if (!empty($old_teachers)) {
                    if(!array_key_exists($teacher_id, $old_teachers)) {
                        EduAssignCourseTeachers_Provider::create([
                            'course_id'  => $course_id,
                            'teacher_id' => $teacher_id
                        ]);
                    }
                } else {
                    EduAssignCourseTeachers_Provider::create([
                        'course_id'  => $course_id,
                        'teacher_id' => $teacher_id,
                    ]);
                }
            }

            $output['messege'] = 'Teachers has been Assigned';
            $output['msgType'] = 'success';

            return redirect()->back()->with($output);
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }
}
