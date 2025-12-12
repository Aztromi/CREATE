@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>User</h1>
    <hr>
    <div class="mt-60 mb-60">
        <form>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Profile Photo</label>
                    <input class="form-control form-control-lg" type="file" placeholder="Profile Photo">
                </div>
                <div class="col img-holder">
                    <img src="" alt="" class="img-fluid">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">First Name</label>
                    <input class="form-control form-control-lg" type="text" placeholder="First Name">
                </div>
                <div class="col">
                    <label for="">Last Name</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Last Name">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Email Address</label>
                    <input class="form-control form-control-lg" type="email" placeholder="Email Address">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">CMS Access</label>
                    <select class="form-select mb-3" aria-label="">
                        <option value="yes">YES</option>
                        <option value="no">NO</option>
                      </select>
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Type/Role</label>
                    <select class="form-select mb-3" aria-label="">
                        <option value="superadmin">Super Administrator</option>
                        <option value="admin">Administrator</option>
                        <option value="editor">Editor</option>
                        <option value="bdu">Business Development Unit</option>
                    </select>
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Function Access</label>
                    <ul class="list-group permission-list">
                        <li>
                            <input type="checkbox" id="func-1" name="ids[]" value="1">
                            <label for="func-1" class="parent header">Dashboard</label>
                        </li>
                        <ul class="parent permission-list">
                            <li>
                                <input type="checkbox" id="func-42" name="ids[]" value="42">
                                <label for="func-42" class="parent header">View</label>
                            </li>
                        </ul>
                        <li>
                            <input type="checkbox" id="func-2" name="ids[]" value="2">
                            <label for="func-2" class="parent header">Articles</label>
                        </li>
                        <ul class="parent permission-list">
                            <li>
                                <input type="checkbox" id="func-3" name="ids[]" value="3">
                                <label for="func-3" class="parent header">Create</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-4" name="ids[]" value="4">
                                <label for="func-4" class="parent header">Update</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-5" name="ids[]" value="5">
                                <label for="func-5" class="parent header">Delete</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-6" name="ids[]" value="6">
                                <label for="func-6" class="parent header">Publish</label>
                            </li>
                        </ul>
                        <li>
                            <input type="checkbox" id="func-7" name="ids[]" value="7">
                            <label for="func-7" class="parent header">Banners</label>
                        </li>
                        <ul class="parent permission-list">
                            <li>
                                <input type="checkbox" id="func-39" name="ids[]" value="39">
                                <label for="func-39" class="parent header">Create</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-40" name="ids[]" value="40">
                                <label for="func-40" class="parent header">Edit</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-41" name="ids[]" value="41">
                                <label for="func-41" class="parent header">Delete</label>
                            </li>
                        </ul>
                        <li>
                            <input type="checkbox" id="func-8" name="ids[]" value="8">
                            <label for="func-8" class="parent header">Page Categories</label>
                        </li>
                        <ul class="parent permission-list">
                            <li>
                                <input type="checkbox" id="func-10" name="ids[]" value="10">
                                <label for="func-10" class="parent header">Create</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-11" name="ids[]" value="11">
                                <label for="func-11" class="parent header">Update</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-12" name="ids[]" value="12">
                                <label for="func-12" class="parent header">Delete</label>
                            </li>
                        </ul>
                        <li>
                            <input type="checkbox" id="func-13" name="ids[]" value="13">
                            <label for="func-13" class="parent header">Pages</label>
                        </li>
                        <ul class="parent permission-list">
                            <li>
                                <input type="checkbox" id="func-14" name="ids[]" value="14">
                                <label for="func-14" class="parent header">Create</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-15" name="ids[]" value="15">
                                <label for="func-15" class="parent header">Update</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-16" name="ids[]" value="16">
                                <label for="func-16" class="parent header">Delete</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-17" name="ids[]" value="17">
                                <label for="func-17" class="parent header">Publish</label>
                            </li>
                        </ul>
                        <li>
                            <input type="checkbox" id="func-18" name="ids[]" value="18">
                            <label for="func-18" class="parent header">Users</label>
                        </li>
                        <ul class="parent permission-list">
                            <li>
                                <input type="checkbox" id="func-20" name="ids[]" value="20">
                                <label for="func-20" class="parent header">Create</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-21" name="ids[]" value="21">
                                <label for="func-21" class="parent header">Update</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-22" name="ids[]" value="22">
                                <label for="func-22" class="parent header">Delete</label>
                            </li>
                        </ul>
                        <li>
                            <input type="checkbox" id="func-23" name="ids[]" value="23">
                            <label for="func-23" class="parent header">User Roles</label>
                        </li>
                        <ul class="parent permission-list">
                            <li>
                                <input type="checkbox" id="func-24" name="ids[]" value="24">
                                <label for="func-24" class="parent header">Create</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-25" name="ids[]" value="25">
                                <label for="func-25" class="parent header">Update</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-26" name="ids[]" value="26">
                                <label for="func-26" class="parent header">Delete</label>
                            </li>
                        </ul>
                        <li>
                            <input type="checkbox" id="func-27" name="ids[]" value="27">
                            <label for="func-27" class="parent header">Functions</label>
                        </li>
                        <ul class="parent permission-list">
                            <li>
                                <input type="checkbox" id="func-28" name="ids[]" value="28">
                                <label for="func-28" class="parent header">Create</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-29" name="ids[]" value="29">
                                <label for="func-29" class="parent header">Update</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-30" name="ids[]" value="30">
                                <label for="func-30" class="parent header">Delete</label>
                            </li>
                        </ul>
                        <li>
                            <input type="checkbox" id="func-31" name="ids[]" value="31">
                            <label for="func-31" class="parent header">Email Logs</label>
                        </li>
                        <ul class="parent permission-list">
                            <li>
                                <input type="checkbox" id="func-32" name="ids[]" value="32">
                                <label for="func-32" class="parent header">View</label>
                            </li>
                        </ul>
                        <li>
                            <input type="checkbox" id="func-33" name="ids[]" value="33">
                            <label for="func-33" class="parent header">Options</label>
                        </li>
                        <ul class="parent permission-list">
                            <li>
                                <input type="checkbox" id="func-35" name="ids[]" value="35">
                                <label for="func-35" class="parent header">Create</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-37" name="ids[]" value="37">
                                <label for="func-37" class="parent header">Update</label>
                            </li>
                            <li>
                                <input type="checkbox" id="func-38" name="ids[]" value="38">
                                <label for="func-38" class="parent header">Delete</label>
                            </li>
                        </ul>
                    </ul>
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <button class="btn btn-primary">SUBMIT</button>
                    <a class="btn btn-disabled" href="{{ url('admin/user-list') }}">CANCEL</a>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection