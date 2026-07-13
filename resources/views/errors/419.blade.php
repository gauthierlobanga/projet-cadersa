@extends('errors::minimal')

@section('title', __('Session expirée'))
@section('code', '419')
@section('message', __('Session expirée'))
@section('description', __('Votre session a expiré pour protéger vos données. Actualisez la page puis réessayez.'))
