<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogPostUpdateRequest;
use App\Http\Requests\BlogPostCreateRequest;
use App\Models\BlogPost;
use App\Repositories\BlogPostRepository;
use App\Repositories\BlogCategoryRepository;

class PostController extends BaseController
{
    /**
     *
     * @package App\Http\Controllers\Blog\Admin
     */

    /**
     * @var BlogPostRepository
     */
    private $blogPostRepository;

    /**
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepository;

    /**
     * PostController constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->blogPostRepository = app(BlogPostRepository::class);
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    public function index()
    {
        $paginator = $this->blogPostRepository->getALLWithPaginate();
        return view('blog.admin.posts.index',compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogPost();
        $categoryList =
            $this->blogCategoryRepository->getForComboBox();
        return view('blog.admin.posts.edit', compact('item','categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();
        $item = (new BlogPost())->create($data);

        if ($item){
            return redirect()->route('blog.admin.posts.edit',[$item->id])
                ->with(['succes'=> 'успешно сохранено']);
        }else{
            return back()->withErrors(['msg'=>'ошибка сохранения'])
                ->withInput();
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
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)){
            abort(404);
        }

        $categoryList =
            $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.posts.edit',
        compact('item','categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BlogPostUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)){
            return back()
                ->withErrors(['msg'=>"Запись id = [{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();

        if (empty($data['slug'])){
            $data['slug']=\Str::slug($data['title']);
        }
        if (empty($item->publishef_at) && $data['is_published']){
            $data['published_at'] = Carbon::now();
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
        //dd(__METHOD__,request()->all(),$id);
        //софт удаление в бд остается
        //$result = BlogPost::destroy($id);
        //полное удаление из бд
        $result = BlogPost::where('id',$id)->forceDelete();
        if ($result){
            return redirect()
                ->route('blog.admin.posts.index')
                ->with(['success'=>"запись id[$id] удалена"]);
        }else{
            return back()->withErrors(['msg'=>'Ошибка удаления']);
        }
    }
}
