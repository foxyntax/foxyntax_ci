# Foxyntax_CI | A REST API CodeIgniter 
Foxyntax_CI is Codeigniter 3 with REST API and new Security library | Matches with [Vue-CLI 3](https://github.com/vuejs/vue-cli)

## Motivationn
As you know, Codeigniter doesn't support REST API and using api out of boxes by default.
Now, this project provide some features for help you to create your REST API. this project will match
with [axios](https://github.com/axios/axios) in front-end

## Features
###### Features in the project are too many and divided into 4 main parts You can control these part inside your javascript or another client site in your applications or website and they includes:

- Authentication
- Queries REST API
- Media REST API
- SESSION REST API

NOTE: *these features will upgraded, also you can add your custom configurations*

## Dependencies

######  We are using some libraries which was lunched before and they includes:

- [UNIREST Library](https://github.com/delsuza/unirest-codeigniter)
- [JWT Helper](https://github.com/ParitoshVaidya/CodeIgniter-JWT-Sample/tree/master/application/helpers)
- [JDF Converter](https://github.com/MahdiMajidzadeh/Codeigniter-jdf/blob/master/Jdf.php)
- Static Tables on Database

Note: *If you don't want to use our "ci_" tables, you can't use auth controllers, just delete them manually or edit*

## Installation

####*easy mode*

###### If you want to use repository as a new project, just copy this project to your host, then follow these commands:

<b>Config foxyntax.php:</b>

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
<b>-> Config constants.php:</b>

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
####*dev mode*:

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
###### You can learn how to send HTTP request (POST recommended), we provide some controllers for get your "application/json" content and do your actions,here it is:

NOTE: *all of libraries are using JWT methods and you must have and
set api key in your header request*.

###Using Query Controller
###### The query controllers use REST API and provide some query_builders from Foxyntax_CI by using "query" libraries.

####Json Properties:
1. "func": *string* - It defines your function which will running in 
[Query Builder Class](https://codeigniter.com/userguide3/database/query_builder.html?highlight=query%20builder),
[File Upload Class](https://codeigniter.com/userguide3/libraries/file_uploading.html?highlight=upload)
and [Session Library](https://codeigniter.com/userguide3/libraries/sessions.html?highlight=session)
like "upload", "download", "CURD" and 'session' function and etc.

2. "cols" : *string* - It defines your coloumns which slect on your tables of SQL
3. "table": *string* - It defines your table which select in SQL

4. "join": *array* - It defines array of objects have 2 properties: "query" and "combine" <br><br>
✔ "table"    : *string* - It defines your table which will join with first table <br><br>
✔ "condition": *string* - It defines your condition like : "ci_user.id = ci_media.user_id" <br><br>
✔ "type"     : *string* - It's optional and NULL is default value for it, other values like $type parameter join() in Codeigniter

5. "where" : *array*  - It defines array of objects have 2 properties: "query" and "combine" <br><br>
✔ "query"  : *string* - It defines your condition like : "id = 1" <br><br>
✔ "combine": *string* - It's *optional* and will set "AND" by default. If you need or_where()
instead of where(), set "OR" this property.

6. "have": *array* - It's like "where" in number 5 and by config "combine" property, you can switch between have() and
or_have() functions.

7. "like": *array*  - It defines an object have 3 properties: "field", "match", "side", "combine" <br><br>
✔ "field": *string* - It defines coloumn name <br><br>
✔ "match": *string* - It defines your value which you looking for like it <br><br>
✔ "side" : *string* - It defines your value which you looking for like it <br><br>
✔ "side" : *string* - It's like another "combine" property in "where" or "have" <br><br>

8. "order": *array*  - It defines array of objects have 2 properties: "col" and "val" <br><br>
✔ "field" : *string* - It defines coloumn name <br><br>
✔ "match" : *string* - It defines your value which you looking for like it <br><br>

9. "responseType": *string* - It helps you to decide what type your response? and get values like:
"numRows", "row", "rowArray", "resaultArray" and finally defines "result" by default if it's not defined.

10. "fomratDate": *string* - It defines Regex string for change timestamp to string data by JDF.php, It's property is
special and must be config as you want, however It's converting your column which their names is "timestamp", "start", "end"

11. "row": *array* - It's another special property and when you need add value to your table, you need this property
instead of "cols", also this property can convert your "password" and "timestamp" to hash and timestamp automatically

12. "result": *bool* - It's a special property, too. when you run custom query, you need to say would you want to get
response or not, "result" do it for you.

13. "query": *string*  - It defines your SQL order manually and used with "result" and custom query only.
14. "limit": *string*  - It defines and used for "read" request function like select()
15. "offset": *string* - It defines and used for "read" request function like select_max()<br><br><br>


###### Now you know our JSON parameters and you must to know how to call Query Library?<br><br>
####Call Query Library:
You have to send your json by "HTTP" request like POST and before that, you need JSON Web Token and set it on your "HEADER" request to access your end point. Here, It's our patterns of URL request in Query Library: 

```php
    // URL : http://YOUR_DOMAIN/api/query/curd/NAME_OF_FUNCTION
```

###### And here they are main functions in Query Library:

- create: includes "insert" | "insertBatch" ("insert" is a default value in it's "func" property)

- read: includes "join" | "count" | "select_sum" | "select_max" | "select_min" | "select_avg" | "select_distinct" | "select"
("select" is a default value in it's "func" property)

- update: includes "update" | "updateBatch" ("update" is a default value in it's "func" property)

- delete: includes "empty" | "truncate" | "delete" ("delete" is a default value in it's "func" property)

- custom: just call it and that will run your custom string query
 
#### Properties of Functions
###### For each function you can config your json request, It wont difficult. Because of your knowledge about JSON properties, we just tell you their names based of "func" property

NOTE: *Italic properties is optional*

- #####create

1. insert     : "row" | "table"
2. insertBatch: is like insert

- #####read

1. select   : *"cols"* | "table" | *"where"* | *"have"* | *"order"* | *"like"* | *"responseType"* | *"fomratDate"* | *"limit"* | *"offset"*
2. selectDis: is like select 
3. selectAvg: is like select 
4. selectMin: is like select 
5. selectMax: is like select
6. join     : select like with "join" property
7. count    : "table" | *"where"* | *"have"* | *"order"* | *"like"*

- #####update

1. update: "row" | "table" | *"where"* | *"have"* | *"order"* | *"like"* |
2. updateBatch: is like insert

- #####delete

1. empty   : "table"
2. truncate: "table"
3. delete  : "table" | *"where"* | *"have"* | *"order"* | *"like"* |

- #####custom

1. for custom request you won't need to set "func" property, just set "query" !


###Using Sessions Controller
###### The Sessions controllers use REST API and provide to set or read sessions by usins session library in codeigniter

####Json Properties:

1. "flash" : *string* - It defines for set or read flash data
2. "sess"  : *string* - It defines for set or read session
3. "temp"  : *string* - It defines for set or read temp
4. "expire": *int* - It defines for set expirations

####Call Sessions Libraries:
as you know, you must follow this format to set url for HTTP requests:

```php
    // URL : http://YOUR_DOMAIN/api/sessions/sess/NAME_OF_FUNCTION
```

###### And here they are main functions in Sessions Libraries, we just tell you their names based of "func" property
- session: includes "addSess" | "readSess" | "checkSess" | "destroy" | "unsetSess"
("unsetSess" is a default value in it's "func" property)

- flash: includes "addFlash" | "readFlash" | "keepFlash" | "unsetFlash"
("unsetFlash" is a default value in it's "func" property)

- temp: includes "addTemp" | "readTemp" | "unsetTemp"
("unsetTemp" is a default value in it's "func" property)

#### Properties of Functions

NOTE: *Italic properties is optional*

- #####session

1. addSess  : "sess"
2. readSess : "sess"
3. checkSess: "sess"
3. distroy  : "sess"
4. unsetSess: "sess"

- #####temp

1. addTemp  : "temp" | "expire"
2. readTemp : "temp"
3. unsetTemp: "temp"

- #####flash

1. addFlash  : "flash"
2. readFlash : "flash"
3. keepFlash : "flash"
4. unsetFlash: "flash"

###Using Media Controller


## Credits

## Licenses

