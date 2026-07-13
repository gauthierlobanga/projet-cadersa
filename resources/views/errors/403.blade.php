@extends('errors::minimal')

@section('title', __('Accès refusé'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Accès refusé'))
@section('description', __('Votre compte ne dispose pas des autorisations nécessaires pour ouvrir cette page.'))
