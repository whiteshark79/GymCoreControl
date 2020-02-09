<?php

function active($path){
    return  request()->is($path) ? 'active' : '';
}

function error_input($campo){
    return  request()->is($campo) ? 'is-invalid' : '';
}
