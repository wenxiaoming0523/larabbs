<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;
use App\Handlers\ImageUploadHandler;
use App\Models\User;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{
	    //链式调用定义的方法 withOrder()
		$topics = $topic->withOrder($request->order)->paginate(10);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{
        $topic->fill($request->all());
       // $topic= $request->all();
        $topic->user_id = Auth::id();
        $topic->save();

		//$topic = Topic::create($request->all());
		return redirect()->route('topics.show', $topic->id)->with('message', '帖子创建成功!');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploader,User $user)
    {

        $data= [
            "success"=>false,
            "msg"=>"上传失败!", # optional
            "file_path"=> ""
        ];
     //   $data = $request->all();

       // 判断是否有上传文件，并赋值给 $file
       $file  = $request->upload_file;

       //dd($file);
        if ($file) {
            //  $result = $uploader->save($request->avatar, 'avatars', $user->id);
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', $user->id,416);
            // 图片保存成功的话
            if ($result) {
               // $data['avatar'] = $result['path'];
                $data['file_path'] = $result['path'];
                $data['msg'] = "上传成功!";
                $data['success'] = true;
    }
        }
        return $data;
            }




}
