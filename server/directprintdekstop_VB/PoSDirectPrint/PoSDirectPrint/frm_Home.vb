Imports System.Net.Http
Imports System.Text
Imports Newtonsoft.Json
Imports System.Net
Imports System.IO
Imports Newtonsoft.Json.Linq

Public Class frm_Home
    Private DS As New DataSet
    Public Sub New()
        Me.Hide()
        Dim f As New Form1
        f.ShowDialog()

        If LoginStatus Then
            InitializeComponent()
        End If
    End Sub

    Private Sub GenerateDataHeader()
        Dim DT As New DataTable("View")

        DT.Columns.Add("id", GetType(Integer))
        DT.Columns.Add("Nama Printer", GetType(String))
        DT.Columns.Add("Interface", GetType(String))
        DT.Columns.Add("Device Address", GetType(String))

        DS.Tables.Add(DT)
    End Sub
    Private Sub GenerateData()
        Dim url As String = My.Settings.base_url + "printerlist"

        Dim parameters As New Dictionary(Of String, String) From {
            {"RecordOwnerID", LoginResult.data.RecordOwnerId},
            {"DeviceAddress", ""}
        }
        Dim json As String = JsonConvert.SerializeObject(parameters)

        Dim responseContent As String = PostRequest(url, json)
        Console.WriteLine("Response content: " & responseContent)

        Dim result As PrinterResult = JsonConvert.DeserializeObject(Of PrinterResult)(responseContent)

        Console.WriteLine(result)

        If result.success Then
            _PrinterResult = result

            For Each user In result.data
                Dim DR As DataRow = DS.Tables("View").NewRow()

                DR("id") = user.id
                DR("Nama Printer") = user.NamaPrinter
                DR("Interface") = user.PrinterInterface
                DR("Device Address") = user.DeviceAddress

                DS.Tables("View").Rows.Add(DR)
            Next
        End If

        ShowData()
    End Sub

    ' Tampilkan Data Sesuai Kriteria
    Private Sub ShowData(Optional ByVal ID As String = "")

        Me.Cursor = Cursors.WaitCursor
        View.SuspendLayout()

        'Baca Data
        Dim BS As New BindingSource

        BS.DataSource = DS
        BS.DataMember = "View"

        View.RowTemplate.Height = 16
        View.DataSource = BS

        'Format Kolom
        Dim Column As DataColumn
        For Each Column In DS.Tables("View").Columns
            If Column.DataType.Name.ToUpper = "DATETIME" Then
                View.Columns(Column.ColumnName).DefaultCellStyle.Format = "dd/MM/yyyy"
                View.Columns(Column.ColumnName).DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter
                View.Columns(Column.ColumnName).HeaderCell.Style.Alignment = DataGridViewContentAlignment.MiddleCenter
            End If

            If Column.DataType.Name.ToUpper = "DOUBLE" Then
                View.Columns(Column.ColumnName).DefaultCellStyle.Format = "#,##0.00"
                View.Columns(Column.ColumnName).DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleRight
                View.Columns(Column.ColumnName).HeaderCell.Style.Alignment = DataGridViewContentAlignment.MiddleRight
            End If
        Next

        'Set Posisi Baris Aktif
        If ID <> "" Then
            BS.Position = BS.Find("Kode Wilayah", ID)
        End If

        'Tampilkan Jumlah Baris
        Status.Text = "Total : " + View.RowCount.ToString + " Baris"

        Me.Cursor = Cursors.Default
        View.ResumeLayout()

    End Sub

    'Eksekusi Menu
    Private Sub Execute(ByVal ID As String)

        Dim DataKey As String = If(View.Rows.Count = 0, "", View(0, View.CurrentCell.RowIndex).Value.ToString())
        Dim DataKey2 As String = If(View.Rows.Count = 0, "", View(2, View.CurrentCell.RowIndex).Value.ToString())

        Select Case ID
            Case "btAdd"
                '---------------------------------------------------------------------------------------------------------
                Dim FormAdd As New Frm_AddPrinter
                FormAdd.ShowDialog()

                ShowData()
                '---------------------------------------------------------------------------------------------------------

            Case "btRefresh"

                '---------------------------------------------------------------------------------------------------------
                ShowData()
                If View.RowCount > 0 Then
                    View.Focus()
                End If
                '---------------------------------------------------------------------------------------------------------

        End Select
jump:
    End Sub

    Private Sub frm_Home_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        GenerateDataHeader()
        GenerateData()
    End Sub

    'Jika Toolbar Di Click
    Private Sub Toolbar_ItemClicked(ByVal sender As System.Object, ByVal e As System.Windows.Forms.ToolStripItemClickedEventArgs) Handles Toolbar.ItemClicked
        Execute(e.ClickedItem.Name)
    End Sub
End Class
