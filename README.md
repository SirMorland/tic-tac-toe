# A RESTful Tic Tac Toe API

This is a REST API for the classic Tic Tac Toe game.

## How to play?

Send POST requests to [localhost:80/tic-tac-toe/](localhost:80/tic-tac-toe/), for example:

`curl -d "action=start" -X POST localhost:80/tic-tac-toe/`

You get a different JSON responses based on your actions as listed on this document.

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
<pre>{
	"playerID":"xxxxxxxxxx",
	"gameID":"xxxxxxxxxx",
	"side":"O|X",
}</pre>
			<p>On failure:</p>
<pre>{
	"error":"xxxxxxxxxx"
}</pre>
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
<pre>{
    "status":"notStarted|started|ended",
    "turn":"O|X",
    "state":
    [
        ["O|X|null","O|X|null","O|X|null"],
        ["O|X|null","O|X|null","O|X|null"],
        ["O|X|null","O|X|null","O|X|null"]
    ]
    (,"winner":"O|X|tied")
}</pre>
			<p>On failure:</p>
<pre>{
	"error":"xxxxxxxxxx"
}</pre>
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
<pre>{
    "status":"notStarted|started|ended",
    "turn":"O|X",
    "state":
    [
        ["O|X|null","O|X|null","O|X|null"],
        ["O|X|null","O|X|null","O|X|null"],
        ["O|X|null","O|X|null","O|X|null"]
    ]
    (,"winner":"O|X|tied")
}</pre>
			<p>On failure:</p>
<pre>{
	"error":"xxxxxxxxxx"
}</pre>
		</td>
		<td>
			<p>Places X or O depending which you are to the speficied position. Positions goes as follows:</p>
<pre>+---+---+---+
| 1 | 2 | 3 |
+---+---+---+
| 4 | 5 | 6 |
+---+---+---+
| 7 | 8 | 9 |
+---+---+---+</pre>
			<h3>Example</h3>
			<code>curl -d "action=place&amp;gameID=1234567890&amp;playerID=abcdefghij&amp;position=5" -X POST localhost:80/tic-tac-toe/</code>
		</td>
	</tr>
</table>
* = required
