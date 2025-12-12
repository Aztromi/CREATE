


<div class="col-xs-12 col-lg-6 login-banner" id="workImg" style="background-image:url('{{ asset('folder_user-uploads/' . $story->id . '/stories/' . $story->homeStoryLatest->cover_image) }}')">
    <section>
        <div>
            <h1>
                
            </h1>
        </div>
    </section>
    <div class="artBy">
        <p>
            Artwork by {{ $story->profile->dispName }}
        </p>
    </div>
</div>