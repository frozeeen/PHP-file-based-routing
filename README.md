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
2. Update the config inside the `router/app.php`.
3. and presto! all set.

### Structure

The structure is very simple

```php
config # A folder contains some of the configurations
pages # This is where your pages will live
public # Maybe robots.txt, sitemap, some of your CSS, JS and other assets
router # And, this is where some tiny-little-bit magic polynomial time happens, it's the router
templates # Collections of shared components, requiring .php just like old times
index.php # entry or fallback php file
.htaccess # We don't talk about .htaccess -Dani
```

### How to use this?

To use this, let's head into `pages` folder and make some files.

#### Static routing

```shell
Path: pages/your-awesome-page.php
URL: http://website.com/your-awesome-page
```

#### Dynamic routing

To create a dynamic url like `https://website.com/post?id=YOURPOSTID` we're going to do it like this.

```php
# Create a file
Path: pages/post/[id].get.php

# To access
URL: https://website.com/post/YOURPOSTID
```

and to access the `id` inside our code, it's just like normal `$_GET`, the name between the brackets `[]` is the parameter or key (they call this `slug`).

```php
Showing post ID: <?php echo $_GET['id']; ?>
```

#### Nested Dynamic routing

We can also create a folder to become our slug.

```python
Path: pages/post/[id]/edit.get.php
URL: pages/post/YOURPOSTID/edit
```

So the file structure will look like this and let's add some additional files.

```
/pages
├── post
│   └── [id]
│       ├── index.get.php
│       ├── index.delete.php
│       ├── edit.get.php
```

The following endpoints correspond to the files in the structure above:

```php
GET    /post/123
DELETE /post/123
GET    /post/123/edit
```

### Request method per file

This is heavily inspired by the [`Nitro`](https://nitro.unjs.io/guide/routing) for mapping the request method per file.

Each file is prefixed with the request method and has a .php file extension. For example, if we are creating CRUD functionality, the structure would look like this:

```
/[id]
├── index.get.php
├── index.post.php
├── index.put.php
├── index.delete.php
```

#### Middleware

Yet another very simple middleware.

Middleware is a script that runs before the page script is loaded; it can be used to check authentication or execute high-level intergalactic computations prior to producing the page.

To create a middleware, create a file named **+middleware.php**.

```
/pages
├── auth
│   ├── +middleware.php
│   ├── profile.get.php
│   ├── index.get.php
```

In the file structure above when we try to access `/auth/profile` or any page inside the `/auth` folder, it will first run the **+middleware.php** script.

In addition, if a given user is not authorized to visit a specific endpoint, you can use the `throw404()` inside your **middleware.php** to send a 404 error, this will return the `404.php` inside the `pages` folder.

#### Global Middlewares

The `+middleware.global.php` file is executed **before** the actual page file (`index.php`, etc.). If there are multiple levels of nested directories, all `+middleware.global.php` files in the hierarchy are applied in order, from the root to the current directory.

```plaintext
/pages
├── +middleware.global.php       # Applies to all pages under "pages/"
├── auth
│   ├── +middleware.global.php   # Applies to all files under "auth/"
│   ├── index.php                # Inherits "auth" middleware
│   ├── nested
│   │   ├── index.php            # Inherits "auth" middleware
│   │   └── deep
│   │       ├── index.php        # Inherits "auth" middleware
├── index.php                    # Inherits global middleware from "pages/"
```

PS: If there are multiple levels of nested directories, **all `+middleware.global.php` files in the hierarchy are applied in order**, from the root to the current directory.
