<h1>A RESTful Tic Tac Toe API</h1>
<p>This is a REST API for the classic Tic Tac Toe game.</p>
<h2>How to play?</h2>
<p>Send POST requests to <a href="localhost:80/tic-tac-toe/">localhost:80/tic-tac-toe/</a>, for example:</p>
<code>curl -d "action=start" -X POST localhost:80/tic-tac-toe/</code>
<p>You get a different JSON responses based on your actions as listed on this document.</p>
<table>
	<tr>
		<th>Action</th>
		<th>Arguments</th>
		<th>Return</th>
		<th>Documentation</th>
	</tr>
	<tr>
		<td>start</td>
		<td></td>
		<td>
			<p>On success:</p>
			<code>
				<span>{</span>
				<span>    "playerID":"xxxxxxxxxx",</span>
				<span>    "gameID":"xxxxxxxxxx",</span>
				<span>    "side":"O|X",</span>
				<span>}</span>
			</code>
			<p>On failure:</p>
			<code>
				<span>{</span>
				<span>    "error":"xxxxxxxxxx"</span>
				<span>}</span>
			</code>
		</td>
		<td>
			<p>Starts a new game or joins an existing one.</p>
			<h3>Example</h3>
			<code>curl -d "action=start" -X POST localhost:80/tic-tac-toe/</code>
		</td>
	</tr>
	<tr>
		<td>status</td>
		<td>
			<code>gameID=xxxxxxxxxx*</code>
		</td>
		<td>
			<p>On success:</p>
			<code>
				<span>{</span>
				<span>    "status":"notStarted|started|ended",</span>
				<span>    "turn":"O|X",</span>
				<span>    "state":</span>
				<span>    [</span>
				<span>        ["O|X|null","O|X|null","O|X|null"],</span>
				<span>        ["O|X|null","O|X|null","O|X|null"],</span>
				<span>        ["O|X|null","O|X|null","O|X|null"]</span>
				<span>    ]</span>
				<span>    (,"winner":"O|X|tied")</span>
				<span>}</span>
			</code>
			<p>On failure:</p>
			<code>
				<span>{</span>
				<span>    "error":"xxxxxxxxxx"</span>
				<span>}</span>
			</code>
		</td>
		<td>
			<p>Get the status and turn of the game and the game's state.</p>
			<h3>Example</h3>
			<code>curl -d "action=status&amp;gameID=1234567890" -X POST localhost:80/tic-tac-toe/</code>
		</td>
	</tr>
	<tr>
		<td>place</td>
		<td>
			<code>gameID=xxxxxxxxxx*</code>
			<code>playerID=xxxxxxxxxx*</code>
			<code>position=x*</code>
		</td>
		<td>
			<p>On success:</p>
			<code>
				<span>{</span>
				<span>    "status":"notStarted|started|ended",</span>
				<span>    "turn":"O|X",</span>
				<span>    "state":</span>
				<span>    [</span>
				<span>        ["O|X|null","O|X|null","O|X|null"],</span>
				<span>        ["O|X|null","O|X|null","O|X|null"],</span>
				<span>        ["O|X|null","O|X|null","O|X|null"]</span>
				<span>    ]</span>
				<span>    (,"winner":"O|X|tied")</span>
				<span>}</span>
			</code>
			<p>On failure:</p>
			<code>
				<span>{</span>
				<span>    "error":"xxxxxxxxxx"</span>
				<span>}</span>
			</code>
		</td>
		<td>
			<p>Places X or O depending which you are to the speficied position. Positions goes as follows:</p>
			<code>
				<span>+---+---+---+</span>
				<span>| 1 | 2 | 3 |</span>
				<span>+---+---+---+</span>
				<span>| 4 | 5 | 6 |</span>
				<span>+---+---+---+</span>
				<span>| 7 | 8 | 9 |</span>
				<span>+---+---+---+</span>
			</code>
			<h3>Example</h3>
			<code>curl -d "action=place&amp;gameID=1234567890&amp;playerID=abcdefghij&amp;position=5" -X POST localhost:80/tic-tac-toe/</code>
		</td>
	</tr>
</table>
<p>* = required</p>

<style>
	h1,h2,h3
	{
		color: #f33;
	}
	code
	{
		background-color: #eee;
		padding: 8px;
		display: block;
		counter-reset: code;
	}
	code span
	{
		counter-increment: code;
		display: block;
		white-space: pre;
	}
	code span::before
	{
		content: " " counter(code);
		border-right: 1px solid;
		padding: 0 8px;
		margin-right: 8px;
	}
	code span:nth-child(n+10)::before
	{
		content: counter(code);
	}
	code span:nth-child(even)
	{
		background-color: #ddd;
	}
	table
	{
		border-collapse: collapse;
		width: 100%;
	}
	th
	{
		background-color: #f33;
		color: #fff;
		border: 1px solid #ccc;
		padding: 8px;
	}
	td
	{
		border: 1px solid #ccc;
		padding: 8px;
		vertical-align: top;
	}
</style>