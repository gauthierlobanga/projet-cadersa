@extends('errors::minimal')

@section('title', __('Service indisponible'))
@section('code', '503')
@section('message', __('Service momentanément indisponible'))
@section('description', __('La plateforme est en maintenance ou momentanément saturée. Elle sera de retour très vite.'))
