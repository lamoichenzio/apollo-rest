<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Apollo Endpoints</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/styles/atom-one-dark.min.css">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content-center {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .section {
            margin: 30px;
        }

        .nav-menu a {
            text-decoration: #636B6F;
            font-size: large;
            font-weight: bold;
        }

    </style>
</head>
<body>
<div class="content-center">
    <h1>Apollo Endpoints (/rest...)</h1>
</div>
<div class="section">
    <b>NB:</b> All endpoints except /auth/login requires Bearer Token AUTHENTICATION
</div>

<nav class="nav-menu">
    <ul>
        <li><a href="#auth">Auth</a></li>
        <li><a href="#user">Users</a></li>
        <li><a href="#survey">Surveys</a></li>
        <li><a href="#question_group">Question Groups</a></li>
    </ul>
</nav>

<section id="auth">
    <div class="section">
        <h2>Auth (/auth...)</h2>
        <ul>
            <li>
                <h3><b>POST:</b>
                    <pre>/login</pre>
                </h3>
                <p>Logs in a new user</p>
                <div>
                    <b>Request Body:</b>
                    <pre>
                    <code class="json">
                    {
                        "email": &lt;email&gt;,
                        "password": &lt;password&gt;
                    }
                    </code>
                </pre>
                    <b>Response Body:</b>
                    <pre>
                    <code>
                    {
                        "access_token": &lt;token&gt;,
                        "token_type": "bearer",
                        "expires_in": &lt;expiration time&gt;,
                        "user": &lt;logged user information&gt;
                    }
                    </code>
                </pre>
                </div>
            </li>
            <li>
                <h3><b>POST:</b>
                    <pre>/logout</pre>
                </h3>
                <p>Logout a user based on the token sent</p>
                <div>
                    <b>Request Header:</b>
                    <pre>
                    <code class="json">
                    {
                        "Authorization": "Bearer" &lt;token&gt;
                    }
                    </code>
                </pre>
                    <b>Response Body:</b>
                    <pre>
                    <code>
                    {
                        "message": "Successfully logged out"
                    }
                    </code>
                </pre>
                </div>
            </li>
            <li>
                <h3><b>POST:</b>
                    <pre>/refresh</pre>
                </h3>
                <p>Creates a new token for the current user</p>
                <div>
                    <b>Request Header:</b>
                    <pre>
                    <code class="json">
                    {
                        "Authorization": "Bearer" &lt;token&gt;
                    }
                    </code>
                </pre>
                    <b>Response Body:</b>
                    <pre>
                    <code>
                      {
                        "access_token": &lt;token&gt;,
                        "token_type": "bearer",
                        "expires_in": &lt;expiration time&gt;,
                        "user": &lt;logged user&gt;
                    }
                    </code>
                </pre>
                </div>
            </li>
            <li>
                <h3><b>GET:</b>
                    <pre>/profile</pre>
                </h3>
                <p>Gets information about the current user</p>
                <div>
                    <b>Request Header:</b>
                    <pre>
                    <code class="json">
                    {
                        "Authorization": "Bearer" &lt;token&gt;
                    }
                    </code>
                </pre>
                    <b>Response Body:</b>
                    <pre>
                    <code>
                      {
                        "data": {
                            "id": 2,
                            "username": "aliza.schumm",
                            "email": "junior00@example.org",
                            "firstname": "Bennett",
                            "lastname": "Homenick",
                            "avatar": "http://apollo.test/rest/file/5f4020549c1a0000f10017f1",
                            "role": {
                                "name": "STANDARD",
                                "description": "Standard Role",
                                "created_at": "2020-08-21T11:09:17.000000Z",
                                "updated_at": "2020-08-21T11:09:17.000000Z"
                            },
                            "surveys": [
                                "http://apollo.test/rest/survey/3",
                                "http://apollo.test/rest/survey/11",
                                "http://apollo.test/rest/survey/12"
                            ]
                        }
                    }
                    </code>
                </pre>
                </div>
            </li>
        </ul>
    </div>
</section>
<section id="user">
    <div class="section">
        <h2>User (.../users)</h2>
        <ul>
            <li>
                <h3><b>GET:</b>
                    <pre>/?pag_size=&lt;num&gt;&username=&lt;name&gt;&order=&lt;orderCol&gt;&order_dir=&lt;asc or desc&gt;</pre>
                </h3>
                <p>Returns a list of all the users optionally paginated and filtered</p>
                <div>
                    <h4>Request Params:</h4>
                    <ul>
                        <li>
                            <pre>pag_size</pre>
                            <div>
                                Paginates the result with the defined number of users per page
                            </div>
                        </li>
                        <li>
                            <pre>username</pre>
                            <div>
                                Returns only the users with the given username
                            </div>
                        </li>
                        <li>
                            <pre>order & order_dir</pre>
                            <div>
                                Order the results with the given column.
                                <br>
                                <b>NB:</b> order_dir must be asc or desc.
                            </div>
                        </li>
                    </ul>
                    <h4>Response Body:</h4>
                    If the request has no params:
                    <pre>
                    <code>
                    {
                        "data": [
                            "http://apollo.test/rest/user/1",
                            "http://apollo.test/rest/user/2",
                            "http://apollo.test/rest/user/3",
                            "http://apollo.test/rest/user/4"
                        ]
                    }
                    </code>
                </pre>
                    If the request has the pag_size param:
                    <pre>
                    <code>
                      {
                        "data": [
                            {
                                "id": 1,
                                "username": "admin",
                                "email": "admin@admin.it",
                                "firstname": null,
                                "lastname": null,
                                "avatar": null,
                                "role": {
                                    "name": "ADMIN",
                                    "description": "Admin Role",
                                    "created_at": "2020-08-21T11:09:17.000000Z",
                                    "updated_at": "2020-08-21T11:09:17.000000Z"
                                },
                                "surveys": [
                                    "http://apollo.test/rest/survey/1",
                                    "http://apollo.test/rest/survey/2",
                                    "http://apollo.test/rest/survey/4",
                                    "http://apollo.test/rest/survey/5",
                                    "http://apollo.test/rest/survey/6",
                                    "http://apollo.test/rest/survey/7",
                                    "http://apollo.test/rest/survey/8",
                                    "http://apollo.test/rest/survey/9",
                                    "http://apollo.test/rest/survey/10"
                                ]
                            },
                            {
                                "id": 2,
                                "username": "aliza.schumm",
                                "email": "junior00@example.org",
                                "firstname": "Bennett",
                                "lastname": "Homenick",
                                "avatar": "http://apollo.test/rest/file/5f4020549c1a0000f10017f1",
                                "role": {
                                    "name": "STANDARD",
                                    "description": "Standard Role",
                                    "created_at": "2020-08-21T11:09:17.000000Z",
                                    "updated_at": "2020-08-21T11:09:17.000000Z"
                                },
                                "surveys": [
                                    "http://apollo.test/rest/survey/3",
                                    "http://apollo.test/rest/survey/11",
                                    "http://apollo.test/rest/survey/12"
                                ]
                            }
                        ],
                        "links": {
                            "first": "http://apollo.test/rest/user?page=1",
                            "last": "http://apollo.test/rest/user?page=2",
                            "prev": null,
                            "next": "http://apollo.test/rest/user?page=2"
                        },
                        "meta": {
                            "current_page": 1,
                            "from": 1,
                            "last_page": 2,
                            "path": "http://apollo.test/rest/user",
                            "per_page": "2",
                            "to": 2,
                            "total": 4
                        }
                    }
                    </code>
                </pre>
                    If the request has only the username param:
                    <pre>
                    <code>
                      {
                        "data": [
                            {
                                "id": 2,
                                "username": "aliza.schumm",
                                "email": "junior00@example.org",
                                "firstname": "Bennett",
                                "lastname": "Homenick",
                                "avatar": "http://apollo.test/rest/file/5f4020549c1a0000f10017f1",
                                "role": {
                                    "name": "STANDARD",
                                    "description": "Standard Role",
                                    "created_at": "2020-08-21T11:09:17.000000Z",
                                    "updated_at": "2020-08-21T11:09:17.000000Z"
                                },
                                "surveys": [
                                    "http://apollo.test/rest/survey/3",
                                    "http://apollo.test/rest/survey/11",
                                    "http://apollo.test/rest/survey/12"
                                ]
                            }
                        ]
                    }
                    </code>
                </pre>
                </div>
            </li>
            <li>
                <h3><b>GET:</b>
                    <pre>/{user_id}</pre>
                </h3>
                <p>Gets information about a specific user</p>
                <div>
                    <b>Response Body:</b>
                    <pre>
                    <code>
                      {
                        "data": {
                            "id": 2,
                            "username": "aliza.schumm",
                            "email": "junior00@example.org",
                            "firstname": "Bennett",
                            "lastname": "Homenick",
                            "avatar": "http://apollo.test/rest/file/5f4020549c1a0000f10017f1",
                            "role": {
                                "name": "STANDARD",
                                "description": "Standard Role",
                                "created_at": "2020-08-21T11:09:17.000000Z",
                                "updated_at": "2020-08-21T11:09:17.000000Z"
                            },
                            "surveys": [
                                "http://apollo.test/rest/survey/3",
                                "http://apollo.test/rest/survey/11",
                                "http://apollo.test/rest/survey/12"
                            ]
                        }
                      }
                    </code>
                </pre>
                </div>
            </li>
            <li>
                <h3><b>POST:</b>
                    <pre>/</pre>
                </h3>
                <p>Creates a new user. Don't need authorization.</p>
                <div>
                    <h4>Request body:</h4>
                    <pre>
                    <code>
                      {
                        "username" (required|min:4): &lt;username&gt;,
                        "password" (required|min:5): &lt;password&gt;,
                        "email"(required): &lt;email&gt;,
                        "firstname": &lt;firstname&gt;,
                        "lastname": &lt;lastname&gt;,
                        "avatar": {
                            "name": &lt;filename&gt;,
                            "data": &lt;filedata&gt;
                        }
                      }
                    </code>
                </pre>
                    <h4>Response Body:</h4>
                    <pre>
                    <code>

                        HTTP STATUS: 201

                        {
                            "self": &lt;path link to the user&gt;
                        }

                    </code>
                </pre>
                </div>
            </li>
            <li>
                <h3><b>PUT:</b>
                    <pre>/{user_id}</pre>
                </h3>
                <p>Updates an existing user</p>
                <p><b>NB:</b> A user can only be updated by himself or an admin user</p>
                <div>
                    <h4>Request body:</h4>
                    All the attributes are not required. Only the attributes send with the request will be updated for
                    the
                    user,
                    the others not sent will still be the same.
                    <pre>
                    <code>
                      {
                        "username" (not blank if present|min:4): &lt;username&gt;,
                        "password" (not blank if present|min:5): &lt;password&gt;,
                        "old_password" (required if password attribute is present): &lt;old user password&gt;
                        "email"(not_blank_if_present): &lt;email&gt;,
                        "firstname": &lt;firstname&gt;,
                        "lastname": &lt;lastname&gt;,
                        "avatar": &lt;new object representing the file or "delete" to only delete the current icon&gt;
                      }
                    </code>
                </pre>
                    <h4>Response:</h4>
                    <pre>
                    <code>
                        HTTP STATUS: 204
                    </code>
                </pre>
                </div>
            </li>
            <li>
                <h3><b>DELETE:</b>
                    <pre>/{user_id}</pre>
                </h3>
                <p>Deletes an existing user</p>
                <p><b>NB:</b> A user can only be deleted by himself or an admin user</p>
                <div>
                    <h4>Response:</h4>
                    <pre>
                    <code>
                        HTTP STATUS: 204
                    </code>
                </pre>
                </div>
            </li>
        </ul>
    </div>
</section>
<section id="survey">
    <div class="section">
        <h2>Survey (../surveys)</h2>
        <ul>
            <li>
                <h3>
                    <b>GET:</b>
                    <pre>/?user_id=&lt;user_id&gt;&pag_size=&lt;pag_size&gt;&name=&lt;name&gt;&order=&lt;orderCol&gt;&order_dir=&lt;asc or desc&gt;</pre>
                </h3>
                Returns the list of surveys eventually filtered and paginated.
                <h4>Request Params</h4>
                <ul>
                    <li>
                        <pre>pag_size</pre>
                        <div>
                            Paginates the results with the defined number of surveys per page
                        </div>
                    </li>
                    <li>
                        <pre>user_id</pre>
                        <div>
                            Filters the surveys by the user creator
                        </div>
                    </li>
                    <li>
                        <pre>name</pre>
                        <div>
                            Filters the surveys with a name LIKE the parameter. It's not an exact query.
                        </div>
                    </li>
                    <li>
                        <pre>order & order_dir</pre>
                        <div>
                            Order the results with the given column.
                            <br>
                            <b>NB:</b> order_dir must be asc or desc.
                        </div>
                    </li>
                </ul>
                <h4>Response body</h4>
                <p>If request has no params:</p>
                <pre>
                <code>
                    {
                        "data": [
                            "http://apollo.test/rest/survey/1",
                            "http://apollo.test/rest/survey/2",
                            "http://apollo.test/rest/survey/3",
                            "http://apollo.test/rest/survey/4",
                            "http://apollo.test/rest/survey/5",
                            "http://apollo.test/rest/survey/6",
                            "http://apollo.test/rest/survey/7",
                            "http://apollo.test/rest/survey/8",
                            "http://apollo.test/rest/survey/9",
                            "http://apollo.test/rest/survey/10",
                            "http://apollo.test/rest/survey/11",
                            "http://apollo.test/rest/survey/12"
                        ]
                    }
                </code>
            </pre>
                <p>If request has the pag_size attribute:</p>
                <pre>
                <code>
                    {
                        "data": [
                            {
                                "id": 1,
                                "name": "eligendi",
                                "description": "Voluptas atque vel fuga.",
                                "icon": null,
                                "secret": 0,
                                "active": 1,
                                "start_date": "2016-07-31T00:00:00.000000Z",
                                "end_date": "1981-01-24T00:00:00.000000Z",
                                "url_id": "http://schneider.com/sint-eum-numquam-doloremque-eaque-numquam-in-debitis.html",
                                "user": "http://apollo.test/rest/user/1",
                                "question_groups": [
                                    "http://apollo.test/rest/questionGroup/1",
                                    "http://apollo.test/rest/questionGroup/2"
                                ]
                            },
                            {
                                "id": 2,
                                "name": "eius",
                                "description": "Dolore aut aut magnam.",
                                "icon": null,
                                "secret": 0,
                                "active": 1,
                                "start_date": "2009-12-01T00:00:00.000000Z",
                                "end_date": "2006-09-26T00:00:00.000000Z",
                                "url_id": "http://www.koch.org/",
                                "user": "http://apollo.test/rest/user/1",
                                "question_groups": [
                                    "http://apollo.test/rest/questionGroup/3",
                                    "http://apollo.test/rest/questionGroup/4"
                                ]
                            }
                        ],
                        "links": {
                            "first": "http://apollo.test/rest/survey?page=1",
                            "last": "http://apollo.test/rest/survey?page=6",
                            "prev": null,
                            "next": "http://apollo.test/rest/survey?page=2"
                        },
                        "meta": {
                            "current_page": 1,
                            "from": 1,
                            "last_page": 6,
                            "path": "http://apollo.test/rest/survey",
                            "per_page": "2",
                            "to": 2,
                            "total": 12
                        }
                    }
                </code>
            </pre>
                <p>If request has one of the query attributes different from pag_size:</p>
                <pre>
                <code>
                    {
                        "data": [
                            {
                                "id": 3,
                                "name": "excepturi",
                                "description": "Qui vel et qui sapiente et et.",
                                "icon": null,
                                "secret": 0,
                                "active": 1,
                                "start_date": "2005-09-03T00:00:00.000000Z",
                                "end_date": "1970-05-29T00:00:00.000000Z",
                                "url_id": "http://www.batz.com/et-itaque-hic-sunt-autem-praesentium-magni",
                                "user": "http://apollo.test/rest/user/2",
                                "question_groups": []
                            },
                            {
                                "id": 11,
                                "name": "test",
                                "description": "adadasdasdasd",
                                "icon": "http://apollo.test/rest/file/5f401e009c1a0000f10017ef",
                                "secret": 0,
                                "active": 0,
                                "start_date": null,
                                "end_date": null,
                                "url_id": null,
                                "user": "http://apollo.test/rest/user/2",
                                "question_groups": []
                            },
                            {
                                "id": 12,
                                "name": "prova",
                                "description": null,
                                "icon": "http://apollo.test/rest/file/5f401e059c1a0000f10017f0",
                                "secret": 1,
                                "active": 0,
                                "start_date": "2020-06-20T00:00:00.000000Z",
                                "end_date": null,
                                "url_id": null,
                                "user": "http://apollo.test/rest/user/2",
                                "question_groups": []
                            }
                        ]
                    }
                </code>
            </pre>
            </li>
            <li>
                <h3>
                    <b>GET</b>
                    <pre>/{survey_id}</pre>
                </h3>
                <p>Returns information for a specific survey:</p>
                <h4>Response Body</h4>
                <pre>
                <code>
                    {
                        "data": {
                            "id": 1,
                            "name": "eligendi",
                            "description": "Voluptas atque vel fuga.",
                            "icon": null,
                            "secret": 0,
                            "active": 1,
                            "start_date": "2016-07-31T00:00:00.000000Z",
                            "end_date": "1981-01-24T00:00:00.000000Z",
                            "url_id": "http://schneider.com/sint-eum-numquam-doloremque-eaque-numquam-in-debitis.html",
                            "user": "http://apollo.test/rest/user/1",
                            "question_groups": [
                                "http://apollo.test/rest/questionGroup/1",
                                "http://apollo.test/rest/questionGroup/2"
                            ]
                        }
                    }
                </code>
            </pre>
            </li>
            <li>
                <h3>
                    <b>POST</b>
                    <pre>/</pre>
                </h3>
                <p>
                    Creates a new survey
                </p>
                <h4>Request Body</h4>
                Here is an example of a request body with some validation requirements:
                <pre>
                <code>
                    {
                        "name" &lt;required&gt; : "prova",
                        "description": "blablabla",
                        "secret" &lt;boolean&gt; : false,
                        "active" &lt;boolean&gt; : true,
                        "icon" &lt;not empty if present&gt;: {
                            "name" &lt;required if icon is present&gt;: "icon",
                            "data" &lt;required if icon is present&gt;: &lt;Base64 encoded file&gt;
                        },
                        "start_date" &lt;must be greater than the actual date&gt; : "25-08-2020",
                        "end_date" &lt;must be greater than start_date&gt; : "26-08-2020",
                        "url_id" &lt;must be present if the active field is true&gt; : "http://apollo.test/asdds"
                    }
                </code>
            </pre>
                <h4>Response</h4>
                <pre>
                <code>
                    HTTP STATUS: 201

                    {
                        "self": "http://apollo.test/rest/surveys/8"
                    }
                </code>
            </pre>
            </li>
            <li>
                <h3>
                    <b>PUT</b>
                    <pre>/{survey_id}</pre>
                </h3>
                <p>
                    Updates a specific survey.
                    <br>
                    <b>NB:</b> A survey can be updated only by an admin or his creator.
                </p>
                <h4>Request Body</h4>
                <p>
                    The request body is the same as the create with the only difference of the "icon" attribute that can
                    be:
                </p>
                <ul>
                    <li>A new object representing a file</li>
                    <li>"delete" to only delete the current file</li>
                </ul>
                <p>
                    All the attributes are not mandatory, only the ones sent will be updated for the survey.
                </p>
                <h4>Response</h4>
                <pre>
                <code>
                    HTTP STATUS: 204
                </code>
            </pre>
            </li>
            <li>
                <h3>
                    <b>DELETE</b>
                    <pre>/{survey_id}</pre>
                </h3>
                <p>
                    Deletes a survey.
                    <br>
                    <b>NB:</b> A survey can be deleted only by his creator or by an admin
                </p>
                <h3>Response</h3>
                <pre>
                <code>
                    HTTP STATUS: 204
                </code>
            </pre>
            </li>
            <li>
                <h3>
                    <b>POST</b>
                    <pre>/count</pre>
                </h3>
                <p>
                    Returns the number of surveys eventually filtered by some parameters.
                </p>
                <h4>Request Body</h4>
                <pre>
                <code>
                    {
                        "active" &lt;boolean&gt;:true,
                        "user_id" :"2"
                    }
                </code>
            </pre>
                <h4>Response Body</h4>
                <pre>
                <code>
                    {
                        "count": 4
                    }
                </code>
            </pre>
            </li>
        </ul>
    </div>
</section>
<section id="question_group">
    <div class="section">
        <h2>Question Groups (.../surveys/{survey_id}/question_groups/)</h2>
        <ul>
            <li>
                <h3>
                    <b>GET:</b>
                    <pre>/?pag_size=&lt;pag_size&gt;&title=&lt;title&gt;&order=&lt;orderCol&gt;&order_dir=&lt;asc or desc&gt;</pre>
                </h3>
                Returns the list of question groups eventually filtered and paginated for the specific survey.
                <h4>Request Params</h4>
                <ul>
                    <li>
                        <pre>pag_size</pre>
                        <div>
                            Paginates the results with the defined number of surveys per page
                        </div>
                    </li>
                    <li>
                        <pre>title</pre>
                        <div>
                            Filters the question groups with a title LIKE the parameter. It's not an exact query.
                        </div>
                    </li>
                    <li>
                        <pre>order & order_dir</pre>
                        <div>
                            Order the results with the given column.
                            <br>
                            <b>NB:</b> order_dir must be asc or desc.
                        </div>
                    </li>
                </ul>
                <h3>Response Body</h3>
                <p>If request has no params:</p>
                <pre>
                <code>
                    {
                        "data": [
                            "http://apollo.test/rest/surveys/5/question_groups/6",
                            "http://apollo.test/rest/surveys/5/question_groups/7"
                        ]
                    }
                </code>
            </pre>
                <p>If request has the pag_size attribute:</p>
                <pre>
                <code>
                    {
                        "data": [
                            {
                                "id": 6,
                                "title": "sed",
                                "description": "Enim provident vel non omnis maiores rem labore ipsum. Quos nulla corrupti consequatur maiores est vitae. Quos minima voluptates enim optio. Ut ut facere ab reprehenderit fuga.",
                                "createDate": "2020-09-01T20:11:08.000000Z",
                                "survey": "http://apollo.test/rest/surveys/5"
                            },
                            {
                                "id": 7,
                                "title": "eum",
                                "description": "Hic voluptas et voluptatum. Hic similique quibusdam quibusdam.",
                                "createDate": "2020-09-01T20:11:08.000000Z",
                                "survey": "http://apollo.test/rest/surveys/5"
                            }
                        ],
                        "links": {
                            "first": "http://apollo.test/rest/surveys/5/question_groups?pag_size=2&page=1",
                            "last": "http://apollo.test/rest/surveys/5/question_groups?pag_size=2&page=1",
                            "prev": null,
                            "next": null
                        },
                        "meta": {
                            "current_page": 1,
                            "from": 1,
                            "last_page": 1,
                            "path": "http://apollo.test/rest/surveys/5/question_groups",
                            "per_page": 2,
                            "to": 2,
                            "total": 2
                        }
                    }
                </code>
            </pre>
                <p>If request has one of the query attributes different from pag_size:</p>
                <pre>
                <code>
                    {
                        "data": [
                            {
                                "id": 6,
                                "title": "sed",
                                "description": "Enim provident vel non omnis maiores rem labore ipsum. Quos nulla corrupti consequatur maiores est vitae. Quos minima voluptates enim optio. Ut ut facere ab reprehenderit fuga.",
                                "createDate": "2020-09-01T20:11:08.000000Z",
                                "survey": "http://apollo.test/rest/surveys/5"
                            },
                            {
                                "id": 7,
                                "title": "eum",
                                "description": "Hic voluptas et voluptatum. Hic similique quibusdam quibusdam.",
                                "createDate": "2020-09-01T20:11:08.000000Z",
                                "survey": "http://apollo.test/rest/surveys/5"
                            }
                        ]
                    }
                </code>
            </pre>
            </li>
            <li>
            <li>
                <h3>
                    <b>GET</b>
                    <pre>/{question_group_id}</pre>
                </h3>
                <p>Returns information for a specific question group:</p>
                <h4>Response Body</h4>
                <pre>
                <code>
                    {
                        "data": {
                            "id": 6,
                            "title": "sed",
                            "description": "Enim provident vel non omnis maiores rem labore ipsum. Quos nulla corrupti consequatur maiores est vitae. Quos minima voluptates enim optio. Ut ut facere ab reprehenderit fuga.",
                            "createDate": "2020-09-01T20:11:08.000000Z",
                            "survey": "http://apollo.test/rest/surveys/5"
                        }
                    }
                </code>
            </pre>
            </li>
            <li>
                <h3>
                    <b>POST</b>
                    <pre>/</pre>
                </h3>
                <p>
                    Creates a new Question Group
                </p>
                <p>
                    <b>NB:</b> a question group can be created only by the creator of the related survey.
                </p>
                <h4>Request Body</h4>
                Here is an example of a request body with some validation requirements:
                <pre>
                <code>
                    {
                        "title" &lt;required&gt; : "prova",
                        "description": "blablabla"
                    }
                </code>
            </pre>
                <h4>Response</h4>
                <pre>
                <code>
                    HTTP STATUS: 201
                    {
                        "self": "http://apollo.test/rest/surveys/13/question_groups/12"
                    }
                </code>
            </pre>
            </li>
            <li>
                <h3>
                    <b>PUT</b>
                    <pre>/{question_group_id}</pre>
                </h3>
                <p>
                    Updates a question group.
                </p>
                <p>
                    <b>NB:</b> a question group can be updated only by an admin or his creator and must be present in
                    the related survey.
                </p>
                <h4>Request Body</h4>
                <pre>
                    <code>
                        {
                            "title": &lt;not null if present&gt;
                            "description":
                        }
                    </code>
                </pre>
                <h4>Response Status</h4>
                <pre>
                    <code>
                        204
                    </code>
                </pre>
            </li>
            <li>
                <h3>
                    <b>DELETE</b>
                    <pre>/{question_group_id}</pre>
                </h3>
                <p>
                    Deletes a question group.
                </p>
                <p>
                    <b>NB:</b> a question group can be deleted only by an admin or his creator and must be present in
                    the related survey.
                </p>
                <h4>Response Status</h4>
                <pre>
                    <code>
                        204
                    </code>
                </pre>
            </li>
        </ul>
    </div>
</section>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>
