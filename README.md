# installation

1. rename .env.example file => .env
2. add database correct info => .env
3. run 
<pre><code>composer install</code></pre>
<pre><code>npm install</code></pre>
<pre><code>php artisan key:gen</code></pre>
<pre><code>php artisan migrate:fresh</code></pre>
<pre><code>php artisan db:seed</code></pre>

# run the project
<pre><code>php artisan serve</code></pre>
<pre><code>php artisan queue:work</code></pre>
<pre><code>php artisan websocket:serve</code></pre>
