const mysql = require("mysql2");  // Use mysql2 instead of mysql
const http = require("http");
const url = require("url");
const querystring = require("querystring");
const fs = require("fs");

const conn = mysql.createConnection({
  host: "localhost",
  user: "root",  // Use the correct username
  password: "1234567a",  // Use the correct password
  database: "mydb"
});

conn.connect(function(err) {
  if (err) throw err;
  console.log("Connected to the MySQL server");
});

const server = http.createServer(function(req, res) {
  // Parse the request URL
  const parsedUrl = url.parse(req.url);

  // Get the pathname and query string from the URL
  const pathname = parsedUrl.pathname;
  const query = querystring.parse(parsedUrl.query);

  // Set the response header
  res.writeHead(200, {"Content-Type": "text/html"});

  // Handle different routes
  if (pathname === "/") {
    // Serve the index.html file
    fs.readFile("index.html", function(err, data) {
      if (err) throw err;
      res.end(data);
    });
  } else if (pathname === "/query") {  // Add a route for /query
    // Display the contents of the database
    conn.query("SELECT * FROM mytable", function(err, rows) {
      if (err) throw err;
            let table = "<table><tr><th>ID</th><th>Name</th></tr>";
      rows.forEach(function(row) {
        table += "<tr><td>" + row.id + "</td><td>" + row.name + "</td></tr>";
      });
      table += "</table>";
      res.end(table);
    });
  } else if (pathname === "/add") {
    // Add a row to the database
    const id = query.id;
    const name = query.name;
    conn.query("INSERT INTO mytable (id, name) VALUES (?, ?)", [id, name], function(err, result) {
      if (err) throw err;
      // After adding a row, redirect the user back to the root path
      res.writeHead(301, {"Location": "/"});
      res.end();
    });
  } else if (pathname === "/update") {
    // Update a row in the database
    const id = query.id;
    const name = query.name;
    conn.query("UPDATE mytable SET name = ? WHERE id = ?", [name, id], function(err, result) {
      if (err) throw err;
      // After updating a row, redirect the user back to the root path
      res.writeHead(301, {"Location": "/"});
      res.end();
    });
  } else if (pathname === "/delete") {
    // Delete a row from the database
    const id = query.id;
    conn.query("DELETE FROM mytable WHERE id = ?", [id], function(err, result) {
      if (err) throw err;
      // After deleting a row, redirect the user back to the root path
      res.writeHead(301, {"Location": "/"});
      res.end();
    });
  }
});

server.listen(80)
