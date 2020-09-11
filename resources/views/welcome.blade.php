<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Apollo Endpoints</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/styles/atom-one-dark.min.css">
    <style>
        html,
        body {
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
        <li>
            Questions:
            <ul>
                <li><a href="#input_questions">Input Questions</a></li>
                <li><a href="#multi_questions">Multi Questions</a></li>
            </ul>
        </li>
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
                    All the attributes are not required. Only the attributes send with the request will be updated
                    for
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
                    The request body is the same as the create with the only difference of the "icon" attribute that
                    can
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
                <p>If request doesn't have pag_size attribute:</p>
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
                    <b>GET</b>
                    <pre>/{question_group_id}/questions</pre>
                </h3>
                <p>
                    Get all the questions of the group ordered by the position attribute
                </p>
                <h4>Response</h4>
                <pre>
                    <code>
                        {
                            "data": {
                                "0": {
                                    "id": 5,
                                    "title": "prova",
                                    "description": "asdadad",
                                    "position": 1,
                                    "mandatory": 0,
                                    "icon": "http://apollo.test/rest/files/5f57aeaebf5b000060007cb2",
                                    "questionType": "App\\InputQuestion",
                                    "type": "TEXT",
                                    "createDate": "2020-09-08T16:17:50.000000Z",
                                    "questionGroup": "http://apollo.test/rest/surveys/3/question_groups/3",
                                    "survey": "http://apollo.test/rest/surveys/3"
                                },
                                "3": {
                                    "id": 3,
                                    "title": "Ad omnis numquam eum dolor facere nam est. Ut sit rem sapiente tenetur quia omnis atque consequatur. Ea quos corporis itaque. Itaque quas fugit facere enim illo asperiores voluptatem.",
                                    "description": "Aut unde consectetur dolore aut est. Non possimus odio cumque. Commodi odio modi natus et illo facilis.",
                                    "position": 2,
                                    "mandatory": 0,
                                    "icon": null,
                                    "questionType": "App\\MultiQuestion",
                                    "type": "SELECT",
                                    "other": 1,
                                    "options": [
                                        "update",
                                        "aut",
                                        "neque",
                                        "dadsad",
                                        "dadsad"
                                    ]
                                },
                                "4": {
                                    "id": 4,
                                    "title": "Earum aperiam beatae alias quisquam quod. Praesentium repellat impedit officiis non qui nihil dolor. Quasi voluptatem sed eligendi dolorem mollitia. Quibusdam accusamus quia omnis repellat quidem.",
                                    "description": "Maxime assumenda veritatis et ipsa rerum nisi sit consectetur. Veniam consequuntur eius tempora dolorum aliquid. Quaerat unde doloribus minus eum voluptatem est.",
                                    "position": 5,
                                    "mandatory": 1,
                                    "icon": null,
                                    "questionType": "App\\MultiQuestion",
                                    "type": "RADIO",
                                    "other": 1,
                                    "options": [
                                        "et",
                                        "eligendi",
                                        "doloribus"
                                    ]
                                },
                                "5": {
                                    "id": 7,
                                    "title": "prova",
                                    "description": null,
                                    "position": 6,
                                    "mandatory": 0,
                                    "icon": null,
                                    "questionType": "App\\MultiQuestion",
                                    "type": "CHECK",
                                    "other": 0,
                                    "options": [
                                        "asdadsd",
                                        "asdaddasd"
                                    ]
                                },
                                "6": {
                                    "id": 9,
                                    "title": "prova",
                                    "description": null,
                                    "position": 7,
                                    "mandatory": 0,
                                    "icon": null,
                                    "questionType": "App\\MultiQuestion",
                                    "type": "CHECK",
                                    "other": 0,
                                    "options": [
                                        "asdadsd",
                                        "asdaddasd"
                                    ]
                                },
                                "7": {
                                    "id": 10,
                                    "title": "prova",
                                    "description": null,
                                    "position": 8,
                                    "mandatory": 0,
                                    "icon": null,
                                    "questionType": "App\\MultiQuestion",
                                    "type": "CHECK",
                                    "other": 0,
                                    "options": [
                                        "asdaddasd"
                                    ]
                                },
                                "8": {
                                    "id": 11,
                                    "title": "prova",
                                    "description": null,
                                    "position": 9,
                                    "mandatory": 0,
                                    "icon": null,
                                    "questionType": "App\\MultiQuestion",
                                    "type": "CHECK",
                                    "other": 0,
                                    "options": [
                                        "asdasd",
                                        "asdasdasd"
                                    ]
                                },
                                "9": {
                                    "id": 13,
                                    "title": "prova",
                                    "description": null,
                                    "position": 10,
                                    "mandatory": 0,
                                    "icon": null,
                                    "questionType": "App\\MultiQuestion",
                                    "type": "SELECT",
                                    "other": 1,
                                    "options": [
                                        "asdasd",
                                        "asdasdasd"
                                    ]
                                },
                                "1": {
                                    "id": 6,
                                    "title": "prova",
                                    "description": "asdadad",
                                    "position": 11,
                                    "mandatory": 0,
                                    "icon": "http://apollo.test/rest/files/5f58a7e37176000020004863",
                                    "questionType": "App\\InputQuestion",
                                    "type": "TEXT",
                                    "createDate": "2020-09-09T10:01:07.000000Z",
                                    "questionGroup": "http://apollo.test/rest/surveys/3/question_groups/3",
                                    "survey": "http://apollo.test/rest/surveys/3"
                                },
                                "10": {
                                    "id": 14,
                                    "title": "test",
                                    "description": null,
                                    "position": 13,
                                    "mandatory": 0,
                                    "icon": null,
                                    "questionType": "App\\MultiQuestion",
                                    "type": "SELECT",
                                    "other": 0,
                                    "options": [
                                        "asdasd",
                                        "asdasdasd",
                                        "dadsad",
                                        "dadsad"
                                    ]
                                },
                                "2": {
                                    "id": 7,
                                    "title": "prova",
                                    "description": "asdadad",
                                    "position": 15,
                                    "mandatory": 0,
                                    "icon": "http://apollo.test/rest/files/5f58a8b07176000020004864",
                                    "questionType": "App\\InputQuestion",
                                    "type": "TEXT",
                                    "createDate": "2020-09-09T10:04:32.000000Z",
                                    "questionGroup": "http://apollo.test/rest/surveys/3/question_groups/3",
                                    "survey": "http://apollo.test/rest/surveys/3"
                                }
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
                    <b>NB:</b> a question group can be updated only by an admin or his creator and must be present
                    in
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
                    <b>NB:</b> a question group can be deleted only by an admin or his creator and must be present
                    in
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
<section id="input_questions">
    <div class="section">
        <h2>Input Questions (../surveys/{survey_id}/questions_groups/{question_group_id}/input_questions)</h2>
        <ul>
            <li>
                <h3>GET
                    <pre>/{question_id}</pre>
                </h3>
                <p>
                    Returns information about a specific question of the selected survey.
                </p>
                <h4>Response Body</h4>
                <pre>
                        <code>
                        {
                            "data": {
                                "id": 1,
                                "title": "Autem doloribus nihil pariatur dolores aliquam non itaque. Corrupti magni consequatur quaerat quae quasi molestiae.",
                                "description": "Aut dignissimos nihil et est sunt recusandae. Dolore ad voluptatum maxime deleniti asperiores. Commodi beatae error ipsam tempore. Minus qui minus aliquam exercitationem qui.",
                                "position": 2,
                                "mandatory": 0,
                                "icon": null,
                                "questionType": "App\\InputQuestion",
                                "type": "TEXTAREA",
                                "createDate": "2020-09-07T15:49:18.000000Z",
                                "questionGroup": "http://apollo.test/rest/surveys/1/question_groups/1",
                                "survey": "http://apollo.test/rest/surveys/1"
                            }
                        }
                        </code>
                    </pre>
            </li>
            <li>
                <h3>
                    POST
                    <pre>/</pre>
                </h3>
                <p>Creates a new Input Question</p>
                <p>
                    <strong>NB:</strong> A question can be created only by the user that created the
                    question group and the survey or by an admin.
                </p>
                <h4>Request Body</h4>
                <pre>
                        <code>
                            {
                                "title" &lt;required & max:255&gt;,
                                "description",
                                "mandatory" &lt;true or false&gt;,
                                "position" &lt;required & integer number&gt;,
                                "type" &lt;required and must be one of ('TEXT', 'TEXTAREA', 'NUMBER', 'DATE')&gt;,
                                "icon" &lt;not null if present&gt;:{
                                    "name" &lt;required with icon&gt;
                                    "data" &lt;required with icon (base64 encoded image)&gt;
                                }
                            }
                        </code>
                    </pre>
                <h4>Response Body</h4>
                <pre>
                        <code>
                            {
                                "self": "http://apollo.test/rest/surveys/3/question_groups/5/input_questions/14"
                            }
                        </code>
                    </pre>
            </li>
            <li>
                <h3>
                    PUT
                    <pre>/{question_id}</pre>
                </h3>
                <p>Update an existing Input Question. Only the sent parameters will be updated for the selected
                    question.</p>
                <p>
                    <strong>NB:</strong> A question can be updated only by the user that created the question by an
                    admin.
                </p>
                <h4>Request Body</h4>
                <pre>
                        <code>
                            {
                                "title" &lt;not null if present & max:255&gt;,
                                "description",
                                "mandatory" &lt;not null if present & true or false&gt;,
                                "position" &lt;not null if present & integer number&gt;,
                                "type" &lt;not null if present and must be one of ('TEXT', 'TEXTAREA', 'NUMBER', 'DATE')&gt;
                                "icon" &lt;not null if present&gt;:{
                                    "name" &lt;required with icon != delete&gt;
                                    "data" &lt;required with icon (base64 encoded image) != delete&gt;
                                } &lt;or "delete" to delete the existing icon if present&gt;
                            }
                        </code>
                    </pre>
                <h4>Response Body</h4>
                <pre>
                        <code>
                            HTTP STATUS: 204
                        </code>
                    </pre>
            </li>
            <li>
                <h3>DELETE
                    <pre>/{question_id}</pre>
                </h3>
                <p>
                    Delete a question.
                </p>
                <p>
                    <strong>NB:</strong> A question can be deleted only by the user that created the question or by an
                    admin.
                </p>
                <h4>Response Body</h4>
                <pre>
                    <code>
                        HTTP STATUS: 204
                    </code>
                </pre>
            </li>
        </ul>
    </div>

</section>
<section id="multi_questions">
    <div class="section">
        <h2>Multi Questions (../surveys/{survey_id}/questions_groups/{question_group_id}/multi_questions)</h2>
        <ul>
            <li>
                <h3>GET
                    <pre>/{question_id}</pre>
                </h3>
                <p>
                    Returns information about a specific question of the selected survey.
                </p>
                <h4>Response Body</h4>
                <pre>
                        <code>
                           {
                                "data": {
                                    "id": 4,
                                    "title": "Earum aperiam beatae alias quisquam quod. Praesentium repellat impedit officiis non qui nihil dolor. Quasi voluptatem sed eligendi dolorem mollitia. Quibusdam accusamus quia omnis repellat quidem.",
                                    "description": "Maxime assumenda veritatis et ipsa rerum nisi sit consectetur. Veniam consequuntur eius tempora dolorum aliquid. Quaerat unde doloribus minus eum voluptatem est.",
                                    "position": 5,
                                    "mandatory": 1,
                                    "icon": null,
                                    "questionType": "App\\MultiQuestion",
                                    "type": "RADIO",
                                    "other": 1,
                                    "options": [
                                        {
                                            "id": 20,
                                            "option": "incidunt"
                                        },
                                        {
                                            "id": 21,
                                            "option": "quaerat"
                                        },
                                        {
                                            "id": 28,
                                            "option": "test"
                                        }
                                    ],
                                }
                            }
                        </code>
                    </pre>
            </li>
            <li>
                <h3>
                    POST
                    <pre>/</pre>
                </h3>
                <p>Creates a new Multi Question</p>
                <p>
                    <strong>NB:</strong> A question can be created only by the user that created the
                    question group and the survey or by an admin.
                </p>
                <h4>Request Body</h4>
                <pre>
                        <code>
                            {
                                "title" &lt;required & max:255&gt;,
                                "description",
                                "mandatory" &lt;true or false&gt;,
                                "position" &lt;required & integer number&gt;,
                                "type" &lt;required and must be one of ('CHECK', 'RADIO', 'SELECT')&gt;,
                                "other" &lt;true or false default is false, if type is SELECT it must be false&gt;,
                                "options" &lt;required & min 2&gt;:[
                                    &lt;list of options for the question&gt;
                                ],
                                "icon" &lt;not null if present&gt;:{
                                    "name" &lt;required with icon&gt;
                                    "data" &lt;required with icon (base64 encoded image)&gt;
                                }
                            }
                        </code>
                    </pre>
                <h4>Response Body</h4>
                <pre>
                        <code>
                            {
                                "self": "http://apollo.test/rest/surveys/3/question_groups/5/multi_questions/3"
                            }
                        </code>
                    </pre>
            </li>
            <li>
                <h3>
                    PUT
                    <pre>/{question_id}</pre>
                </h3>
                <p>Update an existing Multi Question. Only the sent parameters will be updated for the selected
                    question.</p>
                <p>
                    <strong>NB:</strong> A question can be updated only by the user that created the question by an
                    admin.
                </p>
                <h4>Request Body</h4>
                <pre>
                        <code>
                            {
                                "title" &lt;not null if present & max:255&gt;,
                                "description",
                                "mandatory" &lt;not null if present & true or false&gt;,
                                "position" &lt;not null if present & integer number&gt;,
                                "type" &lt;not null if present and must be one of ('CHECK', 'RADIO', 'SELECT')&gt;,
                                "other" &lt;true or false, if type is SELECT it must be false&gt;,
                                "options" &lt;not null if present & min 2&gt;:[
                                    &lt;list of options for the question&gt;
                                ],
                                "icon" &lt;not null if present&gt;:{
                                    "name" &lt;required with icon != delete&gt;
                                    "data" &lt;required with icon (base64 encoded image) != delete&gt;
                                } &lt;or "delete" to delete the existing icon if present&gt;
                            }
                        </code>
                    </pre>
                <h4>Response Body</h4>
                <pre>
                        <code>
                            HTTP STATUS: 204
                        </code>
                    </pre>
            </li>
            <li>
                <h3>DELETE
                    <pre>/{question_id}</pre>
                </h3>
                <p>
                    Delete a question.
                </p>
                <p>
                    <strong>NB:</strong> A question can be deleted only by the user that created the question or by an
                    admin.
                </p>
                <h4>Response Body</h4>
                <pre>
                    <code>
                        HTTP STATUS: 204
                    </code>
                </pre>
            </li>
        </ul>
    </div>
    <div class="section">
        <h3>OPTIONS ../multi_questions/{id}/options</h3>
        <ul>
            <li>
                <h3>GET
                    <pre>/</pre>
                </h3>
                <p>
                    Returns all the options for a given question.
                </p>
                <h4>Response Body</h4>
                <pre>
                        <code>
                              {
                                "data": [
                                    {
                                        "id": 7,
                                        "option": "iure"
                                    },
                                    {
                                        "id": 8,
                                        "option": "autem"
                                    },
                                    {
                                        "id": 9,
                                        "option": "soluta"
                                    }
                                ]
                            }
                        </code>
                    </pre>
            </li>
            <li>
                <h3>
                    POST
                    <pre>/</pre>
                </h3>
                <p>Creates a new option for the given question.</p>
                <p>
                    <strong>NB:</strong> An option can be created only by the user that created the question or by an
                    admin.
                </p>
                <h4>Request Body</h4>
                <pre>
                        <code>
                            {
                                "option" &lt;required&gt;: ...
                            }
                        </code>
                    </pre>
                <h4>Response Body</h4>
                <p>
                    Returns the id of the updated question.
                </p>
                <pre>
                        <code>
                            {
                                "self": "http://apollo.test/rest/surveys/3/question_groups/5/multi_questions/3"
                            }
                        </code>
                    </pre>
            </li>
            <li>
                <h3>
                    PUT
                    <pre>/{option_id}</pre>
                </h3>
                <p>Update an existing option.</p>
                <p>
                    <strong>NB:</strong> An option can be updated only by the user that created the question by an
                    admin.
                </p>
                <h4>Request Body</h4>
                <pre>
                        <code>
                            {
                                "option" &lt;required&gt;,
                            }
                        </code>
                    </pre>
                <h4>Response Body</h4>
                <pre>
                        <code>
                            HTTP STATUS: 204
                        </code>
                    </pre>
            </li>
            <li>
                <h3>DELETE
                    <pre>/{option_id}</pre>
                </h3>
                <p>
                    Delete an option.
                </p>
                <p>
                    <strong>NB:</strong> An option can be deleted only by the user that created the question or by an
                    admin.
                </p>
                <h4>Response Body</h4>
                <pre>
                    <code>
                        HTTP STATUS: 204
                    </code>
                </pre>
            </li>
        </ul>
    </div>
</section>
<section id="matrix_questions">
    <div class="section">
        <h2>Matrix Questions (../surveys/{survey_id}/questions_groups/{question_group_id}/matrix_questions)</h2>
        <ul>
            <li>
                <h3>GET
                    <pre>/{question_id}</pre>
                </h3>
                <p>
                    Returns information about a specific question of the selected survey.
                </p>
                <h4>Response Body</h4>
                <pre>
                        <code>
                           {
                            "data": {
                                "title": "Et voluptatem nostrum perferendis maxime quos repudiandae. Ut delectus voluptatem accusamus. Eaque omnis cupiditate dolore.",
                                "description": "Sit officiis deserunt non voluptatibus quibusdam quasi. Quidem voluptates eveniet ut minus est aut sint. Blanditiis magni officiis esse sint ipsa fugit. Impedit laborum sit cumque.",
                                "position": 5,
                                "mandatory": 1,
                                "icon": null,
                                "questionType": "App\\MatrixQuestion",
                                "type": "CHECK",
                                "elements": [
                                    {
                                        "id": 5,
                                        "title": "Quia sint nesciunt labore dolore repellat magnam numquam est. Ut nulla optio nam odio quasi officia adipisci. Laudantium nostrum animi voluptatibus eaque neque."
                                    },
                                    {
                                        "id": 6,
                                        "title": "Magnam explicabo et sed sunt non. Quia et quibusdam blanditiis amet labore. Ducimus aperiam modi ab expedita. Consectetur architecto sapiente et eum nobis nostrum."
                                    }
                                ],
                                "options": [
                                    {
                                        "id": 20,
                                        "option": "incidunt"
                                    },
                                    {
                                        "id": 21,
                                        "option": "quaerat"
                                    },
                                    {
                                        "id": 28,
                                        "option": "test"
                                    }
                                ],
                                "questionGroup": "http://apollo.test/rest/surveys/3/question_groups/3",
                                "survey": "http://apollo.test/rest/surveys/3"
                            }
                        }
                        </code>
                    </pre>
            </li>
            <li>
                <h3>
                    POST
                    <pre>/</pre>
                </h3>
                <p>Creates a new Matrix Question</p>
                <p>
                    <strong>NB:</strong> A question can be created only by the user that created the
                    question group and the survey or by an admin.
                </p>
                <h4>Request Body</h4>
                <pre>
                        <code>
                            {
                                "title" &lt;required & max:255&gt;,
                                "description",
                                "mandatory" &lt;true or false&gt;,
                                "position" &lt;required & integer number&gt;,
                                "type" &lt;required and must be one of ('CHECK', 'RADIO')&gt;,
                                "options" &lt;required & min 2&gt;:[
                                    &lt;list of options for the question&gt;
                                ],
                                "elements" &lt;required & min 2&gt;:[
                                    &lt;list of sub-questions for the question&gt;
                                ],
                                "icon" &lt;not null if present&gt;:{
                                    "name" &lt;required with icon&gt;
                                    "data" &lt;required with icon (base64 encoded image)&gt;
                                }
                            }
                        </code>
                    </pre>
                <h4>Response Body</h4>
                <pre>
                        <code>
                            {
                                "self": "http://apollo.test/rest/surveys/3/question_groups/5/matrix_questions/3"
                            }
                        </code>
                    </pre>
            </li>
            <li>
                <h3>
                    PUT
                    <pre>/{question_id}</pre>
                </h3>
                <p>Update an existing Matrix Question. Only the sent parameters will be updated for the selected
                    question.</p>
                <p>
                    <strong>NB:</strong> A question can be updated only by the user that created the question by an
                    admin.
                </p>
                <h4>Request Body</h4>
                <pre>
                        <code>
                            {
                                "title" &lt;not null if present & max:255&gt;,
                                "description",
                                "mandatory" &lt;not null if present & true or false&gt;,
                                "position" &lt;not null if present & integer number&gt;,
                                "type" &lt;not null if present and must be one of ('CHECK', 'RADIO', 'SELECT')&gt;,
                                "options" &lt;not null if present & min 2&gt;:[
                                    &lt;list of options for the question&gt;
                                ],
                                "elements" &lt;not null if present & min 2&gt;:[
                                    &lt;list of sub-questions for the question&gt;
                                ],
                                "icon" &lt;not null if present&gt;:{
                                    "name" &lt;required with icon != delete&gt;
                                    "data" &lt;required with icon (base64 encoded image) != delete&gt;
                                } &lt;or "delete" to delete the existing icon if present&gt;
                            }
                        </code>
                    </pre>
                <h4>Response Body</h4>
                <pre>
                        <code>
                            HTTP STATUS: 204
                        </code>
                    </pre>
            </li>
            <li>
                <h3>DELETE
                    <pre>/{question_id}</pre>
                </h3>
                <p>
                    Delete a question.
                </p>
                <p>
                    <strong>NB:</strong> A question can be deleted only by the user that created the question or by an
                    admin.
                </p>
                <h4>Response Body</h4>
                <pre>
                    <code>
                        HTTP STATUS: 204
                    </code>
                </pre>
            </li>
        </ul>
    </div>
    <div class="section">
        <h3>OPTIONS ../matrix_questions/{id}/options</h3>
        <ul>
            <li>
                <h3>GET
                    <pre>/</pre>
                </h3>
                <p>
                    Returns all the options for a given question.
                </p>
                <h4>Response Body</h4>
                <pre>
                        <code>
                              {
                                "data": [
                                    {
                                        "id": 7,
                                        "option": "iure"
                                    },
                                    {
                                        "id": 8,
                                        "option": "autem"
                                    },
                                    {
                                        "id": 9,
                                        "option": "soluta"
                                    }
                                ]
                            }
                        </code>
                    </pre>
            </li>
            <li>
                <h3>
                    POST
                    <pre>/</pre>
                </h3>
                <p>Creates a new option for the given question.</p>
                <p>
                    <strong>NB:</strong> An option can be created only by the user that created the question or by an
                    admin.
                </p>
                <h4>Request Body</h4>
                <pre>
                        <code>
                            {
                                "option" &lt;required&gt;: ...
                            }
                        </code>
                    </pre>
                <h4>Response Body</h4>
                <p>
                    Returns the id of the updated question.
                </p>
                <pre>
                        <code>
                            {
                                "self": "http://apollo.test/rest/surveys/3/question_groups/5/matrix_questions/3"
                            }
                        </code>
                    </pre>
            </li>
            <li>
                <h3>
                    PUT
                    <pre>/{option_id}</pre>
                </h3>
                <p>Update an existing option.</p>
                <p>
                    <strong>NB:</strong> An option can be updated only by the user that created the question by an
                    admin.
                </p>
                <h4>Request Body</h4>
                <pre>
                        <code>
                            {
                                "option" &lt;required&gt;,
                            }
                        </code>
                    </pre>
                <h4>Response Body</h4>
                <pre>
                        <code>
                            HTTP STATUS: 204
                        </code>
                    </pre>
            </li>
            <li>
                <h3>DELETE
                    <pre>/{option_id}</pre>
                </h3>
                <p>
                    Delete an option.
                </p>
                <p>
                    <strong>NB:</strong> An option can be deleted only by the user that created the question or by an
                    admin.
                </p>
                <h4>Response Body</h4>
                <pre>
                    <code>
                        HTTP STATUS: 204
                    </code>
                </pre>
            </li>
        </ul>
    </div>
    <div class="section">
        <h3>ELEMENTS ../matrix_questions/{id}/elements</h3>
        <ul>
            <li>
                <h3>GET
                    <pre>/</pre>
                </h3>
                <p>
                    Returns all the elements (sub-questions) for a given question.
                </p>
                <h4>Response Body</h4>
                <pre>
                        <code>
                              {
                                "data": [
                                    {
                                        "id": 1,
                                        "title": "Voluptatum laboriosam repellat architecto eveniet dicta consectetur voluptates. Totam soluta est est voluptatem nobis eos eveniet ullam. Aut sequi dolorum quisquam voluptate eum ut."
                                    },
                                    {
                                        "id": 2,
                                        "title": "Quae ipsam maiores voluptatem exercitationem labore molestiae. Adipisci voluptates accusantium doloribus. Odit sapiente enim pariatur culpa dolores. Non quis quod totam consequuntur velit soluta."
                                    }
                                ]
                            }
                        </code>
                    </pre>
            </li>
            <li>
                <h3>
                    POST
                    <pre>/</pre>
                </h3>
                <p>Creates a new element for the given question.</p>
                <p>
                    <strong>NB:</strong> An element can be created only by the user that created the question or by an
                    admin.
                </p>
                <h4>Request Body</h4>
                <pre>
                        <code>
                            {
                                "title" &lt;required&gt;: ...
                            }
                        </code>
                    </pre>
                <h4>Response Body</h4>
                <p>
                    Returns the id of the updated question.
                </p>
                <pre>
                        <code>
                            {
                                "self": "http://apollo.test/rest/surveys/3/question_groups/5/matrix_questions/3"
                            }
                        </code>
                    </pre>
            </li>
            <li>
                <h3>
                    PUT
                    <pre>/{option_id}</pre>
                </h3>
                <p>Update an existing element.</p>
                <p>
                    <strong>NB:</strong> An element can be updated only by the user that created the question by an
                    admin.
                </p>
                <h4>Request Body</h4>
                <pre>
                        <code>
                            {
                                "element" &lt;required&gt;,
                            }
                        </code>
                    </pre>
                <h4>Response Body</h4>
                <pre>
                        <code>
                            HTTP STATUS: 204
                        </code>
                    </pre>
            </li>
            <li>
                <h3>DELETE
                    <pre>/{option_id}</pre>
                </h3>
                <p>
                    Delete an element.
                </p>
                <p>
                    <strong>NB:</strong> An element can be deleted only by the user that created the question or by an
                    admin.
                </p>
                <h4>Response Body</h4>
                <pre>
                    <code>
                        HTTP STATUS: 204
                    </code>
                </pre>
            </li>
        </ul>
    </div>
</section>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/highlight.min.js"></script>
<script>
    hljs.initHighlightingOnLoad();
</script>
</body>

</html>