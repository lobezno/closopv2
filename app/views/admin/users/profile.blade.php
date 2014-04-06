@extends ('admin/layout')

@section ('title') Perfil @stop

@section ('content')
  <pre>Usuario: {{ $user->user }}</pre>
  
  <pre>Mail: {{ $user->email }} </pre>
  
@stop








