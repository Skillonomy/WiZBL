<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{ env('APP_NAME') }}</title>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

		<!-- Styles -->

		<style type="text/css">

			body {

				font-family: Nunito;

			}

			.container {

				margin: 0 auto;
				width: 80%;

			}

			.table {

				width: 100%;

			}

			.table td {

				padding: 5px;
			}

			.table tr:nth-child(even) {

				background: #CCC

			}

		</style>

	</head>

	<body>

		<div class="container">

			<table class="table">

				<tr>

					<td>id</td>
					<td>trns id</td>
					<td>account</td>
					<td>status</td>
					<td>host</td>
					<td>event</td>
					<td>course</td>
					<td>amount</td>
					<td>date</td>

				</tr>

			@foreach($transactions as $transaction)

				<tr>

					<td>{{ $transaction->id }}</td>
					<td>{{ $transaction->transaction_id }}</td>
					<td>{{ $transaction->wallets->wallet }}</td>
					<td>{{ $transaction->status }}</td>
					<td>{{ $transaction->hosts->name }}</td>
					<td>{{ $transaction->event_type }}</td>
					<td>{{ $transaction->course_id }}</td>
					<td>{{ $transaction->amount }}</td>
					<td>{{ $transaction->created_at }}</td>

				</tr>

			@endforeach

			</table>

		</div>

	</body>

</html>
