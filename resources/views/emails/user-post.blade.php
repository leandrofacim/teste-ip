<h1>Obrigado por se cadastrar</h1> <br>

<p>Nome: {{ $user->name }}</p> <br>
<p>Email: {{ $user->email }}</p><br>
<p>Telefone: {{ $user->telefone }}</p><br>
<p>Endereço: {{ $user->endereco }}</p><br>
<p>Curriculo: {{ $user->curriculo }}</p>

<hr>
<p>IP: {{ $user->ip }}</p>
Email eviado em {{ date('d/m/Y H:i:s') }}