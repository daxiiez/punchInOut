<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-3.3.1.js"></script>
<script src="js/jquery.mask.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js" type="text/javascript"></script>
<script src="js/lodash.js"></script>
<style>

     .img-area {
         position: relative;
     }

    .image {
        display: block;
    }

    @font-face {
        font-family: headers;font-family: headers;
        src: url("font/FC Lamoon/FC Lamoon Bold ver 1.00.ttf");
    }

     @font-face {
         font-family: applyFont;
         src: url('font/EkkamaiStandard-Light.ttf');
     }

     * {
         font-family: applyFont;
     }

    .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        opacity: 0;
        transition: .5s ease;
        background-color: #008CBA;
        cursor: pointer;
    }

    .img-area:hover .overlay {
        opacity: 1;
    }

    .text {
        color: white;
        font-size: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        text-align: center;
    }


    .btn-file {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }

    .simple-form  {
        display: flex;
        overflow-y: scroll;
        padding-bottom: 1.25rem;
    }
    .simple-form input:required {
        margin: 0 .25rem;
        min-width: 125px;
        border: 1px solid #eee;
        border-left: 5px solid;
        border-radius: 5px;
        transition: border-color .5s ease-out;
    }

    .simple-form textarea:required {
        margin: 0 .25rem;
        min-width: 125px;
        border: 1px solid #eee;
        border-left: 5px solid;
        border-radius: 5px;
        transition: border-color .5s ease-out;
    }
    .simple-form textarea:required {
        border-left-color: palegreen;
    }
    .simple-form textarea:invalid {
        border-left-color: salmon;
    }

    .simple-form select:required {
        margin: 0 .25rem;
        min-width: 125px;
        border: 1px solid #eee;
        border-left: 5px solid;
        border-radius: 5px;
        transition: border-color .5s ease-out;
    }
    .simple-form select:required {
        border-left-color: palegreen;
    }
    .simple-form select:invalid {
        border-left-color: salmon;
    }

    .simple-form input:optional {

        border-left-color: #999;
    }
    .simple-form input:required {
        border-left-color: palegreen;
    }
    .simple-form input:invalid {
        border-left-color: salmon;
    }
    .bg-head{
        background: rgba(112, 53, 27, 0.53);
    }
</style>