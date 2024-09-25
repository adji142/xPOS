Imports System.Net.Http
Imports System.Text
Imports Newtonsoft.Json
Imports System.Net
Imports System.IO
Imports Newtonsoft.Json.Linq
Imports FirebaseAdmin.Messaging
Imports Google.Apis.Auth.OAuth2
Imports FirebaseAdmin
Imports Google.Cloud.Firestore
Imports Google.Apis.FirebaseMessaging.v1
Imports Google.Apis.FirebaseMessaging.v1.Data

Module mdGeneral
    Public LoginStatus As Boolean
    Public LoginResult As userReturn
    Public _PrinterResult As PrinterResult
    Function PostRequest(ByVal url As String, ByVal json As String) As String
        Try
            ' Create a WebRequest
            Dim request As WebRequest = WebRequest.Create(url)
            request.Method = "POST"
            request.ContentType = "application/json"

            ' Convert the JSON string to a byte array
            Dim byteArray As Byte() = Encoding.UTF8.GetBytes(json)

            ' Set the ContentLength property of the WebRequest
            request.ContentLength = byteArray.Length

            ' Get the request stream
            Using dataStream As Stream = request.GetRequestStream()
                ' Write the data to the request stream
                dataStream.Write(byteArray, 0, byteArray.Length)
            End Using

            ' Get the response
            Using response As WebResponse = request.GetResponse()
                ' Read the response stream
                Using dataStream As Stream = response.GetResponseStream()
                    Using reader As New StreamReader(dataStream)
                        ' Read the content
                        Return reader.ReadToEnd()
                    End Using
                End Using
            End Using
        Catch ex As WebException
            Console.WriteLine("WebException: " & ex.Message)
            If ex.Response IsNot Nothing Then
                Using reader As New StreamReader(ex.Response.GetResponseStream())
                    Return reader.ReadToEnd()
                End Using
            End If
            Return String.Empty
        Catch ex As IOException
            Console.WriteLine("IOException: " & ex.Message)
            Return String.Empty
        Catch ex As Exception
            Console.WriteLine("Exception: " & ex.Message)
            Return String.Empty
        End Try
    End Function

    Public Function InitializeFirebase()
        Dim pathToServiceAccountKey As String = System.AppDomain.CurrentDomain.BaseDirectory() + "\Auth\firebase_credentials.json"
        Dim credential = GoogleCredential.FromFile(pathToServiceAccountKey)
        FirebaseApp.Create(New AppOptions() With {
            .Credential = credential
        })
    End Function
End Module
