# Creating To-do list REST API With Lumen

reference:
[Create A REST API For ToDo App With Authentication Using Lumen](https://www.cloudways.com/blog/lumen-rest-api-authentication/)

demo account: 
email: yctest@test.com.tw
password: 123456

0. signup 
   url: http://www.voicetube.ml/api/signup
   method: post
   mandatory field: name, email, password

1. login to get api token
   url: http://www.voicetube.ml/api/login
   method: post
   mandatory field: email, password

2. get all to-do lists
   url: http://www.voicetube.ml/api/todo
   method: get
   header: Authorization: bearer {token}

3. get one to-do list
   url: http://www.voicetube.ml/api/todo/{id}
   method: get
   header: Authorization: bearer {token}

4. create one to-do list
   url: http://www.voicetube.ml/api/todo
   method: post
   header: Authorization: bearer {token}
   mandatory field: title(Text), content(Text), attachment(File)

5. update one to-do list
   url: http://www.voicetube.ml/api/todo/{id}
   method: post
   header: Authorization: bearer {token}
   mandatory field: title(Text), content(Text), attachment(File), done_at(Date time)

6. delete one to-do list
   url: http://www.voicetube.ml/api/todo/{id}
   method: delete
   header: Authorization: bearer {token}

7. delete all to-do list
   url: http://www.voicetube.ml/api/todo/all
   method: delete
   header: Authorization: bearer {token}

8. generate a new token
   url: http://www.voicetube.ml/api/refreshtoken?token={token}
   method: get

9. get token status (Only if tokens with TTL or RefreshToken)
   url: http://www.voicetube.ml/api/tokenstatus?token={token}
   method: get
