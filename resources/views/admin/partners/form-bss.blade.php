@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>Business Solutions Partner</h1>
    <hr>
    <div class="mt-60 mb-60">
        <form>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Cover Image</label>
                    <input class="form-control form-control-lg" type="file" placeholder="Cover Image">
                </div>
                <div class="col img-holder">
                    <img src="" alt="" class="img-fluid">
                </div>
            </div><div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Company Logo</label>
                    <input class="form-control form-control-lg" type="file" placeholder="Company Logo">
                </div>
                <div class="col img-holder">
                    <img src="" alt="" class="img-fluid">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Name</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Name">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Email Address</label>
                    <input class="form-control form-control-lg" type="email" placeholder="email@sample.com">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Categories</label>
                    <select class="form-select mb-3" aria-label="" multiple>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Description</label>
                    <input type="text" name="" placeholder="Description" value="" class="form-control" rows="5">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Website</label>
                    <div class="input-group">
                        <span id="basic-addon3" class="input-group-text">https://</span> 
                        <input type="text" name="website" placeholder="" value="" maxlength="200" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Facebook</label>
                    <div class="input-group">
                        <span id="basic-addon3" class="input-group-text">https://www.facebook.com/</span> 
                        <input type="text" name="facebook" placeholder="" value="" maxlength="200" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Instagram</label>
                    <div class="input-group">
                        <span id="basic-addon3" class="input-group-text">https://www.instagram.com/</span> 
                        <input type="text" name="instagram" placeholder="" value="" maxlength="200" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Twitter</label>
                    <div class="input-group">
                        <span id="basic-addon3" class="input-group-text">https://www.twitter.com/</span> 
                        <input type="text" name="twitter" placeholder="" value="" maxlength="200" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">WeChat</label>
                    <div class="input-group">
                        <span id="basic-addon3" class="input-group-text">weixin://dl/chat?</span> 
                        <input type="text" name="wechat" placeholder="" value="" maxlength="200" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-40 mt-60">
                <hr>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">SEO Title</label>
                    <input class="form-control form-control-lg" type="text" placeholder="SEO Title">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">SEO Description</label>
                    <input class="form-control form-control-lg" type="text" placeholder="SEO Description" rows="5">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">SEO Keyword</label>
                    <input class="form-control form-control-lg" type="text" placeholder="SEO Keyword">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <button class="btn btn-primary">SUBMIT</button>
                    <a href="{{ url('admin/articles') }}" class="btn btn-disabled">CANCEL</a>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection