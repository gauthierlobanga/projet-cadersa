@extends('errors::minimal')

@section('title', __('Trop de requêtes'))
@section('code', '429')
@section('message', __('Trop de requêtes'))
@section('description', __('Nous avons reçu trop d’actions en peu de temps. Patientez un instant avant de reprendre.'))
