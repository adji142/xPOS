Imports System.Threading
Module mdlMain
    Sub main()
        ' Optionally, subscribe to a topic or token here

        Console.WriteLine("Listening for messages...")
        While True
            Console.WriteLine("Response ")
            Thread.Sleep(1000)
        End While
        Console.ReadLine()
    End Sub
End Module
