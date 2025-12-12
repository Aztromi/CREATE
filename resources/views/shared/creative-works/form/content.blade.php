<section>

    <!-- Full-screen modal -->
    <div class="modal" id="loadingModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-white">
                <div class="modal-body text-center">
                    <i class="fas fa-spinner fa-spin fa-3x text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card col-lg-12 col-xl-10 mx-auto">
        <div class="card-body">
            <div class="container" id="main-content" style="display: none;">
                <div class="row">
                    <div class="col mt-4 mb-4 text-center">
                        @if($uProcess == 'add')
                            <h1>ADD CREATIVE WORKS</h1>
                        @else
                            <h1>UPDATE CREATIVE WORKS</h1>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive mt-5 mb-5">
                            <form id="frm-creative-work" method="POST" action="@if($uProcess=='add'){{ route('shd.creativeWorks.process-add') }}@elseif($uProcess=='edit'){{ route('shd.creativeWorks.process-edit') }}@endif" enctype="multipart/form-data">
                                @csrf

                                @if($uType == 'admin' && $uProcess == 'add')
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="creative">Creative <span style="color: red;">*</span></label>
                                            <!-- TEMP -->
                                            <!-- <input class="form-control form-control-lg" type="text" id="creative" name="creative" placeholder="Creative" required> -->
                                            <select class="form-control" id="creative" name="creative" required>
                                            <option value="">-</option>
                                            @foreach($creatives as $creative)
                                                <option value="{{ $creative->user_id }}">{{ $creative->dispName }}</option>
                                            @endforeach
                                            </select>
                                            
                                            <div class="error-message text-danger pt-1" id="creative-error"></div>
                                        </div>
                                    </div>
                                @endif

                                @if($uProcess == 'edit')
                                    <input type="hidden" name="slug" id="slug" value="{{ $slug }}">
                                @endif

                                <div class="row">
                                    <div class="col-12">
                                        <div id="banner">
                                        <label for="masthead">Masthead <span style="color: red;">*</span></label>
                                            <input type="file" id="masthead" name="masthead" class="dropify" data-max-file-size="5M" data-allowed-file-extensions="png jpg jpeg" data-height="200" @if($uProcess == 'edit' && $masthead) data-default-file="{{ $masthead }}" @endif data-errors-position="outside"/>
                                            <input type="hidden" id="masthead-change" name="masthead-change">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="error-message text-danger pt-1" id="masthead-error"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <label for="title">Title <span style="color: red;">*</span></label>
                                        <input class="form-control form-control-lg" type="text" id="title" name="title" placeholder="Title" required>
                                        <div class="error-message text-danger pt-1" id="title-error"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <label for="ta-content">Content</label>
                                        <textarea class="form-control" id="ta-content" name="ta-content" rows="20">
                                            <p>&nbsp;</p>
                                        </textarea>
                                        <div class="error-message text-danger pt-1" id="ta-content-error"></div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="cField">Creative Field</label>
                                        <select name="cField[]" id="cField" class="form-control form-control-lg" multiple="multiple" style="width: 100%" required>
                                            -
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <div class="error-message text-danger pb-2" id="cField-error"></div>
                                    </div>
                                </div>




                                <div class="row">
                                    <div class="col-12 text-left">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="publish" value="1" name="publish">
                                            <label class="custom-control-label" for="publish">Publish</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-right">
                                        <button type="submit" class="btn btn-primary">{{ $uProcess == 'add' ? 'Add' : 'Update' }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</section>