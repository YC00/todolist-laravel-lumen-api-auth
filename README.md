# Creating To-do list REST API With Lumen<br />
<br />
reference:<br />
[Create A REST API For ToDo App With Authentication Using Lumen](https://www.cloudways.com/blog/lumen-rest-api-authentication/)
<br />
demo account: <br />
email: yctest@test.com.tw<br />
password: 123456<br />
<br />
0. signup <br />
   url: http://www.voicetube.ml/api/signup<br />
   method: post<br />
   mandatory field: name, email, password<br />
<br />
1. login to get api token<br />
   url: http://www.voicetube.ml/api/login<br />
   method: post<br />
   mandatory field: email, password<br />
<br />
2. get all to-do lists<br />
   url: http://www.voicetube.ml/api/todo<br />
   method: get<br />
   header: Authorization: bearer {token}<br />
<br />
3. get one to-do list<br />
   url: http://www.voicetube.ml/api/todo/{id}<br />
   method: get<br />
   header: Authorization: bearer {token}<br />
<br />
4. create one to-do list<br />
   url: http://www.voicetube.ml/api/todo<br />
   method: post<br />
   header: Authorization: bearer {token}<br />
   mandatory field: title(Text), content(Text), attachment(File)<br />
<br />
5. update one to-do list<br />
   url: http://www.voicetube.ml/api/todo/{id}<br />
   method: post<br />
   header: Authorization: bearer {token}<br />
   mandatory field: title(Text), content(Text), attachment(File), done_at(Date time)<br />
<br />
6. delete one to-do list<br />
   url: http://www.voicetube.ml/api/todo/{id}<br />
   method: delete<br />
   header: Authorization: bearer {token}<br />
<br />
7. delete all to-do list<br />
   url: http://www.voicetube.ml/api/todo/all<br />
   method: delete<br />
   header: Authorization: bearer {token}<br />
<br />
8. generate a new token<br />
   url: http://www.voicetube.ml/api/refreshtoken?token={token}<br />
   method: get<br />
<br />
9. get token status (Only if tokens with TTL or RefreshToken)<br />
   url: http://www.voicetube.ml/api/tokenstatus?token={token}<br />
   method: get<br />
