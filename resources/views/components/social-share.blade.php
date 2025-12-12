@php
    // Get the first segment of the current request URL
    $segment = request()->segment(1);

    // Assign a value to a variable based on the segment value
    if ($segment === 'profile') {
        $pageTitle = $profileData->dispName;
        $pageImg = "";
    } elseif ($segment === 'creative-work') {
        $pageTitle = $work->title;
        $pageImg = asset('folder_user-uploads/' . $work->user->id . '/stories/' . $work->cover_image) ;
    } elseif ($segment === 'article') {
        $pageTitle = $article->name;
        $pageImg = asset('folder_articles/' . $article->asset->path);
    }
     else {
        $pageTitle = 'default';
    }
@endphp

<center>
    <span>SHARE IN SOCIAL</span>
    <br>
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->full() }}" target="_blank" title="Share to Facebook" class="btn"><i class="fab fa-facebook fs-2"></i></a>

    <a href="https://twitter.com/intent/tweet?url={{ url()->full() }}&text={{ $pageTitle }}" target="_blank" title="Share to Twitter" class="btn"><i class="fab fa-twitter fs-2"></i></a>

    <a href="https://www.linkedin.com/shareArticle?url={{ url()->full() }}&title={{ $pageTitle }}" target="_blank" title="Share to LinkedIn" class="btn"><i class="fab fa-linkedin fs-2"></i></a>

    <a href="https://pinterest.com/pin/create/button/?url={{ url()->full() }}&media={{ $pageImg ?? '' }}&description={{ $pageTitle }}" target="_blank" title="Share to Pinterest" class="btn"><i class="fab fa-pinterest fs-2"></i></a>

    <a href="whatsapp://send?text={{ $pageTitle }}+{{ url()->full() }}" target="_blank" title="Share to WhatsApp" class="btn"><i class="fab fa-whatsapp fs-2"></i></a>

    <a href="https://www.reddit.com/submit?url={{ url()->full() }}&title={{ $pageTitle }}" target="_blank" title="Share to Reddit" class="btn"><i class="fab fa-reddit fs-2"></i></a>

    <a onclick="copyUrl()" id="copyLink" title="Click to copy the link" class="btn"><i class="fa fa-share-square fa-regular fs-2"></i></a>
</center>