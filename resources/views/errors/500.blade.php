@extends('errors::minimal')

@section('title', __('Erreur serveur'))
@section('code', '500')
@section('message', __('Quelque chose s’est arrêté'))
@section('description', __('Une erreur inattendue a interrompu la demande. Vous pouvez revenir à l’accueil pendant la récupération.'))
