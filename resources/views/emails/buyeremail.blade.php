@component('mail::message')

<div style="margin-left: 20px; margin-top: 30px">
	<p><b>Hi {{ $data['user_name']}},</b></p><br><br>

	<p>Wishlist was bought successfully. </p><br>

	<p>Wishlist Item Name: {{ $data['name'] }} </p><br>

	<p>Wishlist Item Price: {{ $data['price'] }} </p><br>

	<p>Wishlist Link: <a href="{{ $data['link'] }}">{{ $data['link'] }}</a> </p><br>
</div>