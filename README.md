# Semantic Web Projects

## Author

| NPM           | Name        |
| ------------- |-------------|
| 140810190068  | Fadhillah Akbar Indrawan |

## About Projects

Aplikasi ini untuk melihat data pada hero-hero di game DotA 2, memiliki atribut per hero serta win rate, pick rate, dan juga KDA Ratio

## Requirements

<ul>
    <li>Git</li>
    <li>XAMPP</li>
    <li>PHP</li>
    <li>Browser</li>
    <li>Apache Jena Fuseki</li>
</ul>

## Installation

1. Prepare and install all Requirements
2. Clone Project on **XAMPP** folder (../xampp/htdocs)
    ```sh 
        git clone https://github.com/Fadhill27/Semantic-Web-Project
    ```
3. Run Apache Jena Fuseki on root folder
    ```sh
        fuseki-server
    ```
5. Make 'dota' dataset and add data with `/sparql/data.ttl` to Apache Jena Fuseki on http://localhost:3030/
6. Run the app
    ```sh 
        http://localhost/semantic-web-project/
    ```

