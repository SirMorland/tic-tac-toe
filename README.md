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
			On success:
			```
			{
			    "playerID":"xxxxxxxxxx",
			    "gameID":"xxxxxxxxxx",
			    "side":"O|X",
			}
			```
			On failure:
			```
			{
			    "error":"xxxxxxxxxx"
			}
			```
		</td>
		<td>
			Starts a new game or joins an existing one.
			### Example
			`curl -d "action=start" -X POST localhost:80/tic-tac-toe/`
		</td>
	</tr>
	<tr>
		<td>status</td>
		<td>
			`gameID=xxxxxxxxxx*`
		</td>
		<td>
			On success:
			```
			{
			    "status":"notStarted|started|ended",
			    "turn":"O|X",
			    "state":
			    [
			        ["O|X|null","O|X|null","O|X|null"],
			        ["O|X|null","O|X|null","O|X|null"],
			        ["O|X|null","O|X|null","O|X|null"]
			    ]
			    (,"winner":"O|X|tied")
			}
			```
			On failure:
			```
			{
			    "error":"xxxxxxxxxx"
			}
			```
		</td>
		<td>
			Get the status and turn of the game and the game's state.
			### Example
			`curl -d "action=status&amp;gameID=1234567890" -X POST localhost:80/tic-tac-toe/`
		</td>
	</tr>
	<tr>
		<td>place</td>
		<td>
			`gameID=xxxxxxxxxx*`
			`playerID=xxxxxxxxxx*`
			`position=x*`
		</td>
		<td>
			On success:
			```
			{
			    "status":"notStarted|started|ended",
			    "turn":"O|X",
			    "state":
			    [
			        ["O|X|null","O|X|null","O|X|null"],
			        ["O|X|null","O|X|null","O|X|null"],
			        ["O|X|null","O|X|null","O|X|null"]
			    ]
			    (,"winner":"O|X|tied")
			}
			```
			On failure:
			```
			{
			    "error":"xxxxxxxxxx"
			}
			```
		</td>
		<td>
			Places X or O depending which you are to the speficied position. Positions goes as follows:
			```
			+---+---+---+
			| 1 | 2 | 3 |
			+---+---+---+
			| 4 | 5 | 6 |
			+---+---+---+
			| 7 | 8 | 9 |
			+---+---+---+
			```
			### Example
			`curl -d "action=place&amp;gameID=1234567890&amp;playerID=abcdefghij&amp;position=5" -X POST localhost:80/tic-tac-toe/`
		</td>
	</tr>
</table>
* = required