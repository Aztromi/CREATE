@extends('layouts.app')

@section('content')

<section class="bg_black ">
    <div class="container">
        <div class="row text-center">
            <h1 class="text-center">ARTICLES</h1>
            <p class="text-center">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Mollitia accusamus delectus quod debitis! Dignissimos omnis odio tempora nostrum optio adipisci fugit, officiis sed cumque veritatis vel doloremque dolores facilis aliquid?
            </p>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-1"></div>
            <div class="col col-md-2 stories-nav">
                <div class="form-group has-search">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <div>
                    <form>
                        <div class="form-group">
                          <label for="exampleFormControlSelect1">SORT:</label>
                          <select class="form-control stories-select" id="exampleFormControlSelect1">
                            <option>Newest First</option>
                            <option>Oldest First</option>
                            <option>By Title</option>
                            <option>By Author</option>
                            <option>By Category</option>
                          </select>
                        </div>
                    </form>
                </div>
                <div>
                    <form>
                        <div class="form-group">
                          <label for="exampleFormControlSelect1">FILTER:</label>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                              Category 1
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Category 2
                            </label>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col col-md-8">
                <div class="container">
                    <div class="home_stories stories_page">
                        <article>
                            <img src="https://createphilippines.com/upload/assets/33D2UTUteYJpeP3tUwCxSW2VXypJ5Hs1mFMQH1W2i2y3q65Dpl.jpg" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                        <article>
                            <img src="https://createphilippines.com/upload/assets/PEN8sLqNcvMAfSsfHPGgMO04W0sHO0QfgxMu2dIqDZEvt6u8qT.png" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                        <article>
                            <img src="https://createphilippines.com/upload/assets/liiK9E9u1R3G5c23Wr4DwUxyiLUFIkFNy9n3Jdbnjlawlr87cm.jpg" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                        <article>
                            <img src="https://createphilippines.com/upload/assets/FGc89ETT3Xm9Ig3w5wbB0wuXKaKjvkdwCbc2TM2DYwrxsyUcjw.jpg" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                        <article>
                            <img src="https://createphilippines.com/upload/assets/PEN8sLqNcvMAfSsfHPGgMO04W0sHO0QfgxMu2dIqDZEvt6u8qT.png" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                        <article>
                            <img src="https://createphilippines.com/upload/assets/liiK9E9u1R3G5c23Wr4DwUxyiLUFIkFNy9n3Jdbnjlawlr87cm.jpg" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                        <article>
                            <img src="https://createphilippines.com/upload/assets/FGc89ETT3Xm9Ig3w5wbB0wuXKaKjvkdwCbc2TM2DYwrxsyUcjw.jpg" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                        <article>
                            <img src="https://createphilippines.com/upload/assets/PEN8sLqNcvMAfSsfHPGgMO04W0sHO0QfgxMu2dIqDZEvt6u8qT.png" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                        <article>
                            <img src="https://createphilippines.com/upload/assets/liiK9E9u1R3G5c23Wr4DwUxyiLUFIkFNy9n3Jdbnjlawlr87cm.jpg" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                        <article>
                            <img src="https://createphilippines.com/upload/assets/FGc89ETT3Xm9Ig3w5wbB0wuXKaKjvkdwCbc2TM2DYwrxsyUcjw.jpg" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                        <article>
                            <img src="https://createphilippines.com/upload/assets/liiK9E9u1R3G5c23Wr4DwUxyiLUFIkFNy9n3Jdbnjlawlr87cm.jpg" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                        <article>
                            <img src="https://createphilippines.com/upload/assets/PEN8sLqNcvMAfSsfHPGgMO04W0sHO0QfgxMu2dIqDZEvt6u8qT.png" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                        <article>
                            <img src="https://createphilippines.com/upload/assets/liiK9E9u1R3G5c23Wr4DwUxyiLUFIkFNy9n3Jdbnjlawlr87cm.jpg" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                        <article>
                            <img src="https://createphilippines.com/upload/assets/FGc89ETT3Xm9Ig3w5wbB0wuXKaKjvkdwCbc2TM2DYwrxsyUcjw.jpg" alt="image info" class="img-fluid">
                            <div>
                                <h3>Story Title</h3>
                                <p>By <strong>CREATEPhilippines</strong>, Month XX, Year</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
            <div class="col col-md-1"></div>
        </div>
    </div>
</section>

@endsection