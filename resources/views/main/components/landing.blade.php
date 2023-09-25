@extends('main.index')
@section('content')
<div class="landing">
    <div class="logos">
        <img class="gorgia" src="../assets/gorgia.png" alt="">
        <h2>CRM</h2>
    </div>
</div>
<style>
    .landing{
        width: 100vw;
        height: 100vh;
        position: fixed;
        z-index: 111;
        top: 0;
        background-image: url('../assets/gorgiabc.png');
        background-repeat: no-repeat;
        background-size: cover;
        text-align: center
        }
        .gorgia{
            width: 400px;
            height: auto;
            margin: auto;
        }
        h2{
            color: #0081bf;
            font-size: 60px;
            margin-top: 50px;
        }
        .logos{
            text-align: center;
            height: 300px;
            margin-top: calc(50vh - 150px);
        }
        html{
            overflow-y: hidden;
        }
</style>
@endsection