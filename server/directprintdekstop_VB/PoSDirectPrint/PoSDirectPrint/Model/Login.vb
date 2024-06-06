Public Class Login
    Public Property email As String
    Public Property password As String
End Class

Public Class userReturn
    Public Property success As Boolean
    Public Property message As String
    Public Property data As User
End Class

Public Class User
    Public Property Id As Integer
    Public Property Name As String
    Public Property Email As String
    Public Property EmailVerifiedAt As Object ' Nullable type
    Public Property RecordOwnerId As String
    Public Property BranchId As String
    Public Property Active As String
    Public Property CreatedAt As Object ' Nullable type
    Public Property UpdatedAt As Object ' Nullable type
End Class