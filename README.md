# Foxyntax_CI | A REST API CodeIgniter 
Foxyntax_CI is Codeigniter 3 with REST API and new Security library | Matches with [Vue-CLI 3](https://github.com/vuejs/vue-cli)

## Motivationn
As you know, Codeigniter doesn't support REST API and using api out of boxes by default.
Now, this project provide some features for help you to create your REST API. this project will match
with [axios](https://github.com/axios/axios) in front-end

## Features
Features in the project are too many and divided into 4 main parts You can control these part inside your javascript or another client site in your applications or website and they includes:

- Authentication
- Queries REST API
- Media REST API
- SESSION REST API

###### NOTE:
*these features will upgraded, also you can add your custom configurations*

## Dependencies

We are using some libraries which was lunched before and they includes:

- [UNIREST Library](https://github.com/delsuza/unirest-codeigniter)
- [JWT Helper](https://github.com/ParitoshVaidya/CodeIgniter-JWT-Sample/tree/master/application/helpers)
- [JDF Converter](https://github.com/MahdiMajidzadeh/Codeigniter-jdf/blob/master/Jdf.php)
- Static Tables on Database


###### NOTE:
*If you don't want to use our "ci_" tables, you can't use auth controllers, just delete them manually or edit*

## Installation

### easy mode

If you want to use repository as a new project, just copy this project to your host, then follow these commands:

#### Config foxyntax.php

Set your lenght of salt for encode your files and directories: (*Required*)
```php
$config['salt_file_length'] = 8;
```


Set your base directory for your files and media: (*Required*)
```php
$config['base_media_dir'] = dirname(__DIR__, 2);
```

Config your global Codeigniter uploader library: (*Required*)
```php
$config['allowed_types_uploaded'] = 'png|txt|html';
$config['max_size_uploaded'] = '1000000';
$config['max_width_uploaded'] = '1920';
$config['max_height_uploaded'] = '750';
$config['encrypt_name_uploaded'] = true;
$config['remove_space_uploaded'] = true;
```

Config your api_key for your SMS panel: (*Optional*)
```php
$config['sms_key'] = '';
```

Config your api key to use REST API: (*Required*)
```php
$config['api_key'] = 'daAS5d4bGFsdDfD5GDfgd654dgFGsD66Vg';
```

Config your jwt key to encode your JWT token: (*Required*)
```php
$config['jwt_key'] = '3dfFGsdfdad654dgf5d4b65Ssd4dgFGsDi';
```

Config your expiration JWT token: (*Optional*)
```php
$config['token_timeout'] = 1;
// Generated token will expire in 1 minute for sample code
// Increase this value as per requirement for production
```
#### Config constants.php

Set your URL which want to access your REST API, default value was set: (*Optional*)
```php
defined('ACCESS_CONTROL_ALLOW_ORIGIN')  OR define('ACCESS_CONTROL_ALLOW_ORIGIN', 'Access-Control-Allow-Origin: /*your URL*/');
```

Set your another headers manually, default values was set: 
```php
defined('ACCESS_CONTROL_REQUEST_METHOD')  OR define('ACCESS_CONTROL_REQUEST_METHOD', 'Access-Control-Request-Method: GET, POST, PUT, HEAD');
defined('CONTENT_TYPE')  OR define('CONTENT_TYPE', 'Content-Type: application/json');
defined('ACCESS_CONTROL_ALLOW_HEADERS')  OR define('ACCESS_CONTROL_ALLOW_HEADERS', 'Access-Control-Allow-Headers: Origin, Accept, Content-Type, Authorization, Access-Control-Allow-Origin');
```
### dev mode

If you want to use manually, follow this command:

1. copy and past library | helper directories to your own
2. copy and past controllers | models directories to your own
3. copy and past foxyntax.php to *"application/config"* directory
4. copy and replace constants.php to *"application/config"* directory
5. add ci_"*" tables to your own database
6. config your foxyntax.php and constants.php as we said *above* and 
another required configurations like [database.php](https://codeigniter.com/user_guide/database/configuration.html)
, [config.php](https://codeigniter.com/userguide3/libraries/config.html) and etc.

that's all !

## Documentation
You can learn how to send HTTP request (POST recommended), we provide some controllers for get your "application/json" content and do your actions,here it is:

###### NOTE:
*all of libraries are using JWT methods and you must have and set api key in your header request*.

### Using Query Controller
The query controllers use REST API and provide some query_builders from Foxyntax_CI by using "query" libraries.

#### Json Properties

```js

let body = {


    /* string - 'It defines your function which will running in Query Builder Class and File Upload Class and Session Library like "upload" | "download" | "CURD" and "session_sum" function and etc' */
    func: "join", // example
    
    
    /* string - 'It defines your coloumns which select on your tables of SQL' */
    cols: "ci_user.id, name, family", // example
    
    
    /* string - 'It defines your table which select in SQL' */
    table: "ci_user", // example
    
   
    /* It defines array of objects have 3 properties: "table", "condition" and "type" */
    join: {
        
        /* string - It defines your table which will join with first table */
        table: "ci_media", // example
        
        /* string - It defines your condition
        condition: "ci_user.id = ci_media.user_id", // example
        
        /* string - It's optional and NULL is default value for it, other values like $type parameter join() in Codeigniter */
        type: "both", // example
        
    },
    
    
    /* array - It defines array of objects have 2 properties */
    where: [
        
        
        {query: "ci_user.id = 1"}, // example
        {
        
            /* string - It defines your condition */
            query: "ci_user.id = 2",
            
            /* string - It's *optional* and will set "AND" by default. If you need or_where() instead of where(), set "OR" this property */
            combine: "OR"
            
        }, // example
        
        // and other conditions ... 
       
    ],
    
    
    /* array - It's like "where", you can switch between have() and or_have() functions */
    have: [
        
        {query: "name = "Foxyntax", combine: "AND"}, // example
        
        // and other conditions ... 

    ],
    
    
    /* array - It defines array of objects have 4 properties: "field" | "match" | "side" | "combine" */
    like: [
    
    
        {
        
            /* string - It defines coloumn name */
            filed: "name",
            
            /* string - It defines your value which you looking for like it */
            match: "fox",
            
            /* string - It defines your value which you looking for like it */
            side: "before",
            
            /* string - It's like another "combine" property in "where" or "have" */
            combine: "OR",
            
        }, // example
    
        // and other conditions ... 
    
    ],
    
    /* array - It defines array of objects have 2 properties: "col" and "val" */
    order: [
        
        {
            /* string - It defines coloumn name */
            field: "family",
            
            /* string - It defines your value which you looking for like it */
            match: "DESC"
        
        } // example
        
        // and other conditions ... 
    
    ],
    
    
    /* string - It helps you to decide what type your response? and get values like: "numRows", "row", "rowArray", "resaultArray" and finally defines "result" by default if it's not defined. */
    responseType: "resultArray", // example
    
    
    /* string - It's another special property and when you need add | update values in your table, you need this property instead of "cols", also this property can convert your "password" and "timestamp" to hash and timestamp automatically */
    row: "username, password, timestamp", // example
    
    
    /* bool - It's a special property, too. when you run custom query, you need to say would you want to get response or not, "result" do it for you. */
    result: true, // example
    
    
    /* string - It defines your SQL order manually and used with "result" and custom query only. */
    query: "SELECT ci_user.id, name, family FROM ci_user INNER JOIN ci_media ON ci_media.user_id=ci_user.id", // example
    
    
    /* int  - It defines and used for "read" request function like select() */
    limit: 20 // example
    
    
    /* int - It defines and used for "read" request function like select_max() */
    offset: 10 // example
}

```
Now you know our JSON parameters and you must to know how to call Query Library?<br><br>

#### Call Query Librarys

You have to send your json by "HTTP" request like POST and before that, you need JSON Web Token and set it on your "HEADER" request to access your end point. Here, It's our patterns of URL request in Query Library: 

```php
    // URL : http://YOUR_DOMAIN/api/query/curd/NAME_OF_FUNCTION
```

And here they are main functions in Query Library:

- create: includes "insert" | "insertBatch" ("insert" is a default value in it's "func" property)

- read: includes "join" | "count" | "select_sum" | "select_max" | "select_min" | "select_avg" | "select_distinct" | "select"
("select" is a default value in it's "func" property)

- update: includes "update" | "updateBatch" ("update" is a default value in it's "func" property)

- delete: includes "empty" | "truncate" | "delete" ("delete" is a default value in it's "func" property)

- custom: just call it and that will run your custom string query
 
#### Properties of Functions
    
For each function you can config your json request, It won't difficult. Because of your knowledge about JSON properties, we just tell you their names based of "func" property

###### NOTE:
*optional properties doesn't need to send by HTTP request, however we are using them here to know that how they're working!*

- create functions

1. insert:

```js

 let body = {
    func: "insert", // [optional] : (leave it, if you want to use INSERT query)
    row: "username, password, status, timestamp",
    table: "ci_user"
    
}

```

2. insertBatch: is like insert

- read functions

1. select:

```js

let body = {

    func: "select", [optional] : (leave it, if you want to use SELECT query)
    cols: "id, name, family",  // [optional] : (leave it if you want select all columns) 
    table: "user_meta",
    where: [
        {query: "id = 2"}
    ], // [optional] : ("have", "order" and "like" properties are optional, so leave them if you needn't they)
    responseType: "row", // [optional] : (leave it if you want to get values by result() function)
    formatDate: "H:i:s" // [optional] : (you can config your special coloumns which have timestamp and convert it to JDF)
    limit: null, // [optional] : (leave it if if you needn't) 
    offset: null, // [optional] : (leave it if if you needn't)
    
}
    
```
2. selectDis: is like select, but "func" property required
3. selectAvg: is like select, but "func" property required
4. selectMin: is like select, but "func" property required
5. selectMax: is like select, but "func" property required
6. join:

```js

let body = {
    
    func: 'join',
    cols: 'ci_user.id, first_name, last_name',
    table: 'ci_user',
    join: [
        {table: 'admin_meta', condition: 'admin_meta.user_id = ci_user.id'}
    ],
    where: [
        {query: "id = 2"}
    ], // [optional] : ("have", "order" and "like" properties are optional, so leave them if you needn't they)
    responseType: "row", // [optional] : (leave it if you want to get values by result() function)
    
}
```
7. count:

```js

let body = {

    func: "count",
    table: "ci_options",
    have: [
        {query: "id = 2"}
    ], // [optional] : ("where", "order" and "like" properties are optional, so leave them if you needn't they)

}

```

- update functions

1. update:

```js

let body = {

 func: "update", [optional] : (leave it, if you want to use UPDATE query)
    cols: "id, name, family",  // [optional] : (leave it if you want select all columns) 
    table: "user_meta",
    where: [
        {query: "id = 2"}
    ], // [optional] : ("have", "order" and "like" properties are optional, so leave them if you needn't they)

}

```
2. updateBatch: is like insert, but "func" property required

- delete funcitons

1. empty:

```js

let body = {

    func: "empty"
    table: "user_meta",

}

```

2. truncate:

```js

let body = {

    func: "truncate"
    table: "user_meta",

}

```

3. delete:

```js

let body = {

    func: "delete" [optional] : (leave it, if you want to use DELETE FROM query)
    table: "user_meta",
    where: [
        {query: "id = 2"}
    ], // [optional] : ("have", "order" and "like" properties are optional, so leave them if you needn't they)

}

```

- custom function

1. for custom request you won't need to set "func" property, just set "query" !

### Using Sessions Controllerr

The Sessions controllers use REST API and provide to set or read sessions by usins session library in codeigniter

#### Json Properties

```js

let body = {

    /* string - It defines for set or read flash data */
    flash: "item",
    
    /* string - It defines for set or read session */
    sess: "item",
    
    /* string - It defines for set or read temp */
    temp: "item",
    
    /* int - It defines for set expirations */
    expire: 900,
}

```

#### Call Sessions Libraries
as you know, you must follow this format to set url for HTTP requests:

```php
    // URL : http://YOUR_DOMAIN/api/sessions/sess/NAME_OF_FUNCTION
```

And here they are main functions in Sessions Libraries, we just tell you their names based of "func" property

- session: includes "addSess" | "readSess" | "checkSess" | "destroy" | "unsetSess"
("unsetSess" is a default value in it's "func" property)

- flash: includes "addFlash" | "readFlash" | "keepFlash" | "unsetFlash"
("unsetFlash" is a default value in it's "func" property)

- temp: includes "addTemp" | "readTemp" | "unsetTemp"
("unsetTemp" is a default value in it's "func" property)

#### Properties of Functions

- session

1. addSess:

```js

let body = {

    func: "sess",
    sess: "sessItem",

}

```

2. readSess : is like "addSess"
3. checkSess: is like "addSess"
3. distroy  : is like "addSess"
4. unsetSess: is like "addSess" but you can only set "sess" property in data request

- temp

1. addTemp  : 

```js

let body = {

    func: "temp",
    temp: "tempItem",
    expire: 500 // Secounds

}

```

2. readTemp : is like "addTemp"
3. unsetTemp: is like "addTemp" but you can only set "temp" property in data request

- flash

1. addFlash:

```js

let body = {

    func: "flash",
    flash: "flashItem",

}

```

2. readFlash : is like "addFlash"
3. keepFlash : is like "addFlash"
4. unsetFlash: is like "addFlash" but you can only set "flash" property in data request

### Using Media Controller
The media controllers use REST API and provide many actions which you need for manage your files like "donwload" or "read" them. for using this controller you need our table in your SQL like ci_media

#### Json Properties
```js

let body = {

    /* string - It defines allow types for uploading */
    allowTypes: "png | jpg | pdf",
    
    
    /* string - It defines maximum size of uploaded file */
    maxSize: "2024", // KBs
    
    
    /* string - It defines maximum width of uploaded file */
    maxWith: "1080", // px
    
    
    /* string - It defines maximum height of uploaded file */
    maxHeight: "720", // px
    
    
    /* bool - It defines is it necessary for encrypt name uploaded files or not? */
    encryptName: true,
    
    
    /* bool - It defines is it necessary for remove space uploaded files or not? */
    removeSpace: true,
    
    
    /* bool - It defines do you have one file or more? true means you have more than one */
    multiple: true,
    
    
    /* string - It defines what it your category in media directory? "goods" or "blog" or "content" or "user"? */
    type: "goods",
    
    
    /* string - It defines extention of file which can be writable */
    extFile: ".png",
    
    
    /* string - It defines owner id of file which it's file can be writable */
    ownerId: "105",
    
    
    /* int - It defines id of file in ci_media */
    id: 110,
    
    /* string - It defines name of file which can be writable */
    nameFile: "PsdF43OaddasdS", // your name of file will hashed by this controller and we show you an example like them
    
    
    /* string - It defines full name of your file with extentions */
    file: "PsdF43OaddasdS.png",
    
    
    /* string - It defines origin name of your file without extentions */
    name: "origin_name",
    
    
    /* string - It defines your content */
    content: "some_contnets"
    
    /* string - It defines full path directory your file */
    path: "http://YOUR_DOMAIN/media/.../YOUR_FILE"
     
    
}

```

#### Call Media Libraries
for call this library, you must follow this format to set url for HTTP requests:

```php

    // URL : http://YOUR_DOMAIN/api/media/surf/NAME_OF_FUNCTION/TYPE_OF_FILE
    
    /* 
     * TYPE_OF_FILE is OPTIONAL and should use when you want upload some file(s) which is/are not images like .png or .jpg
     */
     
```

#### Properties of Functions

## Credits
This package supports every javascript frameworks or native application requests, just config and use it! for manage better your request and bring back your equations, we always prefer [axios](https://github.com/LegenD1995/axios) because of it's feature and manage your promises.

Also we work on a CMS via [VUE-CLi 3](https://github.com/vuejs/vue-cli) created by this package and will ready very soon. it's repository will tagged here.

## Licenses
[MIT](LICENSE)
