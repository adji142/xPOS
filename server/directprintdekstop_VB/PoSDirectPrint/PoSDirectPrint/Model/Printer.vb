Public Class PrinterResult
    Public Property success As Boolean
    Public Property message As String
    Public Property data As List(Of oDataPrinter)
End Class

Public Class oDataPrinter
    Public Property id As Integer
    Public Property NamaPrinter As String
    Public Property PrinterInterface As String
    Public Property DeviceName As String
    Public Property DeviceAddress As String
    Public Property PrinterToken As String
    Public Property Used As Integer
    Public Property RecordOwnerID As String
    Public Property created_at As Object
    Public Property updated_at As Object
End Class
