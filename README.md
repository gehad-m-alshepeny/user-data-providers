<h1> Data Providers API </h1>

<h2>Overview</h2>

<p>This project is a Laravel-based application that reads data from two JSON providers (<code>DataProviderX</code> and <code>DataProviderY</code>). It implements an API endpoint <code>/api/v1/users</code> that lists and filters user data based on various criteria</p>


<h2>Key Features Implemented</h2>

<ul>
  <li><strong>Factory Design Pattern</strong>: Used for creating data provider instances dynamically.</li>
<li><strong>Chunking and JsonParser</strong>: Used to efficiently handle large JSON files by breaking them into smaller chunks with LazyCollection and streaming data using JsonParser. This approach reduces memory usage and improves performance, especially when processing large datasets.</li>
  <li><strong>Pipeline for Filtering</strong>: Filters are applied using Laravel's Pipeline for a flexible, modular design.</li>
  <li><strong>Unit and Feature Testing</strong>: Full coverage using Pest for feature tests.</li>
  <li><strong>Dockerized Application</strong>: Simplified setup and deployment using Docker and Docker Compose.</li>
</ul>

<hr>

<h2>Requirements</h2>

<ul>
  <li><strong>Docker</strong> and <strong>Docker Compose</strong> installed.</li>
  <li><strong>PHP 8.2</strong> (used in Docker container).</li>
  <li><strong>MySQL 8.0</strong> (used in Docker container).</li>
</ul>

<hr>

<h2>Setup Instructions</h2>

<h3>1. Clone the Repository</h3>

<pre><code>git clone https://github.com/your-repo/laravel-data-provider-api.git
cd laravel-data-provider-api
</code></pre>

<h3>2. Set Up Docker Environment</h3>

<h4><strong>Build the Docker containers:</strong></h4>

<pre><code>docker-compose build
</code></pre>

<h4><strong>Start the Docker containers:</strong></h4>

<pre><code>docker-compose up -d
</code></pre>

<p>The Laravel app will be available at <a href="http://localhost:8000">http://localhost:8000</a>.</p>

<h3>3. Set Up the Environment</h3>

<p>Copy the example <code>.env</code> file and configure your environment variables:</p>

<pre><code>cp .env.example .env
</code></pre>

<p>Make sure to update the following values in the <code>.env</code> file:</p>

<pre><code>APP_KEY=base64:X4rrandomKeyHere
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
</code></pre>

<h3>4. Generate Application Key</h3>

<p>Generate the application key by running the following command inside the Docker container:</p>

<pre><code>docker-compose exec app php artisan key:generate
</code></pre>

<h3>5. JSON Data Setup</h3>

<p>The project reads data from JSON files (<code>DataProviderX.json</code> and <code>DataProviderY.json</code>). Place these files in the <code>storage/app/data/</code> directory.</p>

<p>Example structure:</p>

<pre><code>storage/app/data/DataProviderX.json
storage/app/data/DataProviderY.json
</code></pre>

<h3>6. Testing the Application</h3>

<h4>Running Pest Tests</h4>

<pre><code>docker-compose exec app ./vendor/bin/pest
</code></pre>

<h3>7. Accessing the API</h3>

<p>After setting up the application, you can access the API at:</p>

<pre><code>http://localhost:8000/api/v1/users&page=1&perPage=100
</code></pre>

<p>Example requests:</p>

<pre><code>http://localhost:8000/api/v1/users?status=authorised&page=1&perPage=100
http://localhost:8000/api/v1/users?provider=DataProviderX&balanceMin=50&balanceMax=200&page=1&perPage=100
http://localhost:8000/api/v1/users?currency=USD&status=refunded&page=1&perPage=100
</code></pre>





