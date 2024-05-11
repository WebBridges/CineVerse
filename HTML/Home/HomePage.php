<?php
include '../../PHP/Utils/auth_request.php';
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <title>Cineverse - Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../CSS/Home/HomePage.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/d9b18796bb.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid p-0 overflow-x-hidden overflow-y-auto" id="body_container">
        <header class="fixed-top border-bottom border-black border-2" id="profile_header">
            <h1 class="text-center m-0 pb-3 pt-3 white-text"><a href="./HomePage.php" id="reload">Cineverse</a></h1>
        </header>
        <main class="align-items-center d-flex justify-content-center">
            <!--Post section-->
            <div id="posts-section">
                <template id="template-posts">
                    <div class="post-header">
                        <div class="row mt-3 mb-3">
                            <div class="col-7 ps-4 d-flex align-items-center">
                                <p class="white-text post-title">Post title</p>
                            </div>
                            <div class="col-2 text-end">
                                <img src="../../img/default-user.jpg" alt=""
                                    class="post-user-photo rounded-circle img-fluid img-thumbnail">
                            </div>
                            <div class="col-3 ps-3 pe-4 d-flex align-items-center text-end justify-content-end">
                                <p class="white-text post-username">Username</p>
                            </div>
                        </div>
                    </div>
                    <div class="post-body">
                        <div class="row">
                            <div class="col text-center post-element">
                            </div>
                        </div>
                        <div class="post-actions row mt-3">
                            <div class="col-2">
                                <button class="btn likes-button">
                                    <em class="fa-regular fa-heart" style="color: #ffffff;"></em>
                                </button>
                            </div>
                            <div class="col-2">
                                <button class="btn comments-button" data-bs-toggle="modal"
                                    data-bs-target="#comments-modal" data-bs-dismiss="modal">
                                    <em class="fa-regular fa-comment" style="color: #ffffff;"></em>
                                </button>
                            </div>
                            <div class="col-8 post-description-container">
                                <p class="white-text post-description">Post description can be very long and take the
                                    whole page</p>
                            </div>
                        </div>
                    </div>
                    <div class="post-footer border-bottom">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-11 text-end pt-1">
                                    <p class="white-text">Like:</p>
                                </div>
                                <div class="col-1 text-end pt-1">
                                    <p class="white-text post-count-likes">0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </main>
        <!--Load more post button-->
        <div class="align-items-center d-flex justify-content-center" id="load-more-post-div">
            <button class="btn-primary" id="load-more-post-button">
                Load 5 more posts
            </button>
        </div>
        <!--Navbar-->
        <nav class="navbar navbar-custom fixed-bottom navbar-expand mx-auto bottom-navbar border border-1 border-light">
            <div class="collapse navbar-collapse" id="bottomNavbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="../Home/HomePage.php" title="HomePage">
                            <svg xmlns="http://www.w3.org/2000/svg" width="54.75" height="52.5" viewBox="0 0 73 70"
                                fill="none">
                                <path
                                    d="M62.9997 27.7557V52.4009H70.4997V27.7557H62.9997ZM51.7497 62.9631H21.7498V70.0046H51.7497V62.9631ZM10.4999 52.4009V27.7557H2.99989V52.4009H10.4999ZM21.7498 62.9631C18.1086 62.9631 15.7536 62.9561 14.0211 62.7378C12.3936 62.5301 11.8836 62.1991 11.5986 61.9316L6.29613 66.9099C8.20862 68.7055 10.5636 69.4061 13.0199 69.7159C15.3748 70.0117 18.3186 70.0046 21.7498 70.0046V62.9631ZM2.99989 52.4009C2.99989 55.6224 2.99239 58.3897 3.30739 60.5972C3.63739 62.9033 4.38364 65.1178 6.29613 66.9099L11.5986 61.9316C11.3136 61.664 10.9611 61.1852 10.7399 59.6572C10.5074 58.0341 10.4999 55.8195 10.4999 52.4009H2.99989ZM62.9997 52.4009C62.9997 55.8195 62.9922 58.0306 62.7597 59.6572C62.5384 61.1852 62.1859 61.664 61.9009 61.9316L67.2034 66.9099C69.1159 65.1143 69.8622 62.9033 70.1922 60.5972C70.5071 58.3862 70.4997 55.6224 70.4997 52.4009H62.9997ZM51.7497 70.0046C55.181 70.0046 58.1284 70.0117 60.4797 69.7159C62.9359 69.4061 65.2947 68.7055 67.2034 66.9099L61.9009 61.9316C61.6159 62.1991 61.1059 62.5301 59.4784 62.7378C57.746 62.9561 55.391 62.9631 51.7497 62.9631V70.0046Z"
                                    fill="white" />
                                <path
                                    d="M2.99988 31.2764L26.1448 9.54638C31.1435 4.85322 33.6448 2.50488 36.7498 2.50488C39.8547 2.50488 42.356 4.85322 47.3547 9.54638L70.4996 31.2764"
                                    fill="white" />
                                <path
                                    d="M2.99988 31.2764L26.1448 9.54638C31.1435 4.85322 33.6448 2.50488 36.7498 2.50488C39.8547 2.50488 42.356 4.85322 47.3547 9.54638L70.4996 31.2764"
                                    stroke="white" stroke-width="5" stroke-linecap="round" />
                                <path
                                    d="M25.4998 52.4009C25.4998 49.1196 25.4998 47.4789 26.0698 46.1868C26.4467 45.3319 26.9994 44.5551 27.6963 43.9009C28.3931 43.2466 29.2205 42.7277 30.131 42.3738C31.5073 41.8387 33.2548 41.8387 36.7498 41.8387C40.2447 41.8387 41.9922 41.8387 43.3685 42.3738C44.2791 42.7277 45.1064 43.2466 45.8033 43.9009C46.5001 44.5551 47.0528 45.3319 47.4297 46.1868C47.9997 47.4789 47.9997 49.1196 47.9997 52.4009V66.4839H25.4998V52.4009ZM51.7497 8.39159C51.7497 6.75093 51.7497 5.93059 52.0347 5.28278C52.4161 4.42181 53.1457 3.73807 54.0634 3.38157C54.7534 3.11047 55.6272 3.11047 57.3747 3.11047C59.1222 3.11047 59.9959 3.11047 60.6859 3.37805C61.6029 3.73614 62.3312 4.42115 62.7109 5.28278C62.9997 5.93059 62.9997 6.75093 62.9997 8.39159V27.7557L51.7497 15.4331V8.39159Z"
                                    fill="white" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Profile/SearchPage.php" title="SearchPage">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48.75" height="48.75" viewBox="0 0 65 65"
                                fill="none">
                                <path d="M47.4992 47.4998L62.4992 62.4997" stroke="white" stroke-width="5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M2.49937 28.2141C2.49937 42.4157 14.012 53.9283 28.2136 53.9283C35.3266 53.9283 41.7654 51.0402 46.4205 46.3727C51.0598 41.7214 53.9278 35.3027 53.9278 28.2141C53.9278 14.0126 42.4151 2.49994 28.2136 2.49994C14.012 2.49994 2.49937 14.0126 2.49937 28.2141Z"
                                    stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Profile/CreatePost.php" title="CreatePost">
                            <svg xmlns="http://www.w3.org/2000/svg" width="49.5" height="48.75" viewBox="0 0 66 65"
                                fill="none">
                                <path
                                    d="M2.9989 32.4998H32.9988M32.9988 32.4998H62.9987M32.9988 32.4998V2.49994M32.9988 32.4998V62.4997"
                                    stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Profile/userpage.php" title="Userpage">
                            <svg xmlns="http://www.w3.org/2000/svg" width="49.5" height="48.75" viewBox="0 0 66 65"
                                fill="none">
                                <path
                                    d="M62.9982 62.4998V55.8331C62.9982 52.2969 61.4179 48.9055 58.6048 46.4051C55.7918 43.9046 51.9765 42.4998 47.9983 42.4998H17.9984C14.0201 42.4998 10.2048 43.9046 7.3918 46.4051C4.57876 48.9055 2.99841 52.2969 2.99841 55.8331V62.4998"
                                    stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M32.9983 29.1665C41.2826 29.1665 47.9983 23.197 47.9983 15.8332C47.9983 8.46946 41.2826 2.49994 32.9983 2.49994C24.7141 2.49994 17.9984 8.46946 17.9984 15.8332C17.9984 23.197 24.7141 29.1665 32.9983 29.1665Z"
                                    stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!--Comments modal-->
    <div class="modal fade" id="comments-modal" tabindex="-1" aria-labelledby="comments-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable align-items-md-center modal-lg">
            <div class="modal-content bg-primary">
                <div class="modal-header justify-content-end">
                    <div class="row">
                        <div class="col-auto">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <template id="template-comments">
                        <div class="comment-container">
                            <div class="row justify-content-start">
                                <div class="col-2 mb-1 col-lg-1">
                                    <img src="../../img/default-user.jpg" alt="" class="img-fluid rounded-circle">
                                </div>
                                <div class="col">
                                    <a href="#" class="fs-5 white-text">Username</a>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="d-flex col-6 align-items-center">
                                    <p class="comment white-text m-0">Comment</p>
                                </div>
                                <div class="d-flex col-2 justify-content-end align-items-center">
                                    <button class="like-comment-button btn">
                                        <em class="fa-regular fa-heart" style="color: #ffffff;"></em>
                                    </button>
                                </div>
                                <div class="d-flex col-2 justify-content-start align-items-center">
                                    <p class="nLikes white-text m-0">0</p>
                                </div>
                                <div class="d-flex col-2 align-items-center">
                                    <button class="btn invisible delete-comment-button">
                                        <em class="fa-solid fa-trash" style="color: #ffffff;"></em>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="modal-footer justify-content-center">
                    <form class="row">
                        <label for="new-comment" class="col-form-label">New Comment:</label>
                        <div class="col-10">
                            <input type="text" id="new-comment" name="new-comment" class="form-control border-dark"
                                placeholder="Write new comment...">
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn border border-black btn-send" name="submit-comment">
                                <em class="fa-solid fa-paper-plane" style="color: #ff8500;"></em>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
    <script src="../../JAVASCRIPT/Home/HomePage.js" type="module"></script>
</body>