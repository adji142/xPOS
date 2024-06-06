Imports System.Net.Http
Imports System.Text
Imports Newtonsoft.Json
Imports System.Net
Imports System.IO
Imports Newtonsoft.Json.Linq
Imports FirebaseAdmin
Imports FirebaseAdmin.Messaging
Imports Google.Apis.Auth.OAuth2

Public Class Form1

    Private Sub GetFCMToken()

    End Sub

    Private Sub Form1_KeyDown(sender As Object, e As KeyEventArgs) Handles MyBase.KeyDown
        Select Case e.KeyCode
            Case Keys.Enter
                e.SuppressKeyPress = True
                SendKeys.Send("{TAB}")
            Case Keys.Escape
                Me.Close()
        End Select
    End Sub

    Private Sub Button_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btLogin.Click, btClose.Click
        Select Case DirectCast(sender, Button).Name
            Case "btLogin"
                '---------------------------------------------------------------------------------------------------------
                btLogin.Enabled = False
                Me.Cursor = Cursors.WaitCursor

                Dim url As String = My.Settings.base_url + "login"

                Dim parameters As New Dictionary(Of String, String) From {
                    {"email", txtKodeUser.Text},
                    {"password", txtPassword.Text}
                }
                Dim json As String = JsonConvert.SerializeObject(parameters)

                Dim responseContent As String = PostRequest(url, json)
                Console.WriteLine("Response content: " & responseContent)

                Dim result As userReturn = JsonConvert.DeserializeObject(Of userReturn)(responseContent)
                'result.data = oData
                'Console.WriteLine(result.success)
                If result.success Then
                    Me.Cursor = Cursors.Default
                    SaveSetting("PoSDirectPrint", "Login", "Email", txtKodeUser.Text)
                    LoginStatus = True
                    LoginResult = result
                    Me.Close()
                Else
                    Me.Cursor = Cursors.Default
                    LoginStatus = False
                    MessageBox.Show(result.message, "#Error", MessageBoxButtons.OK, MessageBoxIcon.Error)
                End If
                '---------------------------------------------------------------------------------------------------------
            Case "btClose"
                '---------------------------------------------------------------------------------------------------------
                Me.Close()
                '---------------------------------------------------------------------------------------------------------
        End Select
        btLogin.Enabled = True
    End Sub

    Private Sub Form1_Shown(sender As Object, e As EventArgs) Handles MyBase.Shown
        Dim Email = GetSetting("XAConsole", "Login", "KodeUser", "")
        LoginStatus = False
        If Email <> "" Then
            txtKodeUser.Text = GetSetting("XAConsole", "Login", "KodeUser", "")
            txtKodeUser.Focus()
            SendKeys.Send("{TAB}")
        End If
    End Sub

    Private Sub Form1_Load(sender As Object, e As EventArgs) Handles MyBase.Load

    End Sub
End Class
