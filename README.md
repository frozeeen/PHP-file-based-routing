## PHP File-based routing

This is my unstable version of file-based routing, inspired by Javascript Libraries/Frameworks, to make my project's URL tiny-little-bit-beautiful even my backend is an instant legacy code.

### Sooo @frozeeen, again what's this?

Well, here you go

```python
https://yourawesome.web/post?id=ABCDEFG12345
to
https://yourawesome.web/post/ABCDEFG12345
```

### Installation

1. Simply clone this project into your machine.
2. Update the config inside the `index.php`.
3. and presto! all set.

### Structure

The structure is very simple

```python
pages # This is where your pages will live
assets # Maybe some of your CSS, JS and other assets
index.php # And this is where some tiny-little-bit magic polynomial time happens, it's the router
.htaccess # We don't talk about .htaccess -Dani
```

### How to use this?

To use this, let's head into `pages` and make some files.

#### Static routing

```python
Path: pages/your-awesome-page.php
URL: http://website.com/your-awesome-page
```

#### Dynamic routing

To create a dynamic url like `https://website.com/post?id=YOURPOSTID` we're going to do it like this.

```python
# Create a file
Path: pages/post/[id].php

# To access
URL: https://website.com/post/YOURPOSTID
```

and to access the value in our code, it's just like normal `$_GET`, the name between the brackets `[]` is the parameter name (they call this `slug`).

```php
Showing post ID: <?php echo $_GET['id']; ?>
```

#### Nested Dynamic routing

We can also create a folder to become our slug.

```python
# Create folder an file
Path: pages/post/[id]/edit.php
URL: pages/post/YOURPOSTID/edit
```

So the file structure will look like this and let's add additional files.

```
pages/
--post/
----[id]/
------edit.php
------show.php
------delete.php
```

#### Middleware

Yet another very simple middleware.

Middleware is a script that runs before the page script is loaded; it can be used to check authentication or execute high-level intergalactic computations prior to producing the page.

To create a middleware, create a file named **+middleware.php**.

```
pages/
--auth/
----+middleware.php
----profile.php
----index.php
```

In the file structure above when we try to access `/auth/profile` or any page inside the `/auth` folder, it will first run the **+middleware.php** script.

In addition, if a given user is not authorized to visit a specific endpoint, you can do **$is_not_found = true** inside your **middleware.php** to send a 404 error.

> $is_not_found variable is a (page exist) flag inside the index.php
