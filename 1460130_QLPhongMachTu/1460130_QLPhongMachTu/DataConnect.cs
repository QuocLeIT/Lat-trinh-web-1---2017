using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using System.Data.SqlClient;
using Microsoft.VisualBasic;
using System.Collections;
using System.Diagnostics;
using System.Xml;
using System.IO;
using System.Configuration;


namespace _1460130_QLPhongMachTu
{
    class DataConnect
    {

        public SqlCommand Cmd { get; set; }
        private SqlDataAdapter dataAp { get; set; }
        private DataTable dataTable { get; set; }
        private SqlConnection Connection { get; set; }

        static XmlDocument doc = null;
        static XmlNode nodeRoot = null;

        public void Connect()
        {
            //Sửdụng tài khoản window
            string ConnectionString = @"Server=.\SQL2014EXPRESS; Database=QLPhongMachTu; Trusted_Connection=True;";
            //Sửdụng tài khoản SQL Server
            //static string ConnectionString2 = @"Server=myServerAddress;Database=myDataBase;User Id=myUsername;Password=myPassword;";      
            Connection = new SqlConnection(ConnectionString);
            try
            {
                if (Connection == null)
                    Connection = new SqlConnection(ConnectionString);
                if (Connection.State != ConnectionState.Closed)
                    Connection.Close();
                Connection.Open();
            }
            catch (SqlException ex)
            {
                throw ex;
            }
        }
        public void Disconnect()
        {
            if (Connection != null && Connection.State == ConnectionState.Open)
                Connection.Close();
        }
      
        //strSql = sp_ReadData hoac strSql = "select * from Account"
        //bang ham Fillbang
        public DataTable ReadNoParemeter(string strSql)
        {
            Connect();
            dataTable = Select(CommandType.Text, strSql);
            Disconnect();
            return dataTable;
        }
        public DataTable Select(CommandType cmdType, string strSql)
        {
            try
            {
                Cmd = Connection.CreateCommand();
                Cmd.CommandText = strSql;
                Cmd.CommandType = cmdType;

                dataAp = new SqlDataAdapter(Cmd);
                dataTable = new DataTable();
                dataAp.Fill(dataTable);

                return dataTable;
            }
            catch (SqlException ex)
            {
                throw ex;
            }
        }

        //strSql = "select * from Account"
        public DataTable FillBang(string strSql)
        {
            Connect();
            dataTable = Select(CommandType.Text, strSql);
            Disconnect();
            return dataTable;
        }

        //---------------------------------------------------------------
        public SqlDataReader GetReader(CommandType cmdType, string strSql)
        {
            try
            {
                Cmd = Connection.CreateCommand();
                Cmd.CommandText = strSql;
                Cmd.CommandType = cmdType;
                return Cmd.ExecuteReader();
            }
            catch (SqlException ex)
            {
                throw ex;
            }
        }

        //----------------------------------------
        //insert, update, delete no parameters
        public int ExcuteNonQuyery(CommandType cmdType, string strSql)
        {
            try
            {
                Connect();
                Cmd = Connection.CreateCommand();
                Cmd.CommandText = strSql;
                Cmd.CommandType = cmdType;

                int nRow = Cmd.ExecuteNonQuery();
                Disconnect();
                return nRow;
            }
            catch (SqlException ex)
            {
                throw ex;
            }
        }

        //insert, update, delete parameters
        //strSql = "insert into Account(uid, pass, type) values (@uid, @pass, @type)";
        public int ExcuteNonQuyery(CommandType cmdType, string strSql, params SqlParameter[] parameters)
        {
            try
            {
                Connect();
                Cmd = Connection.CreateCommand();
                Cmd.CommandText = strSql;
                Cmd.CommandType = cmdType;

                if (parameters != null && parameters.Length > 0)
                    Cmd.Parameters.AddRange(parameters);

                int nRow = Cmd.ExecuteNonQuery();
                Disconnect();
                return nRow;
            }
            catch (SqlException ex)
            {
                throw ex;
            }
        }
        //huong dan
        //------------------------------------------------------------------------------
        public SqlCommand AddParameters(SqlCommand _cmd, string[] ParamName, object[] ParamValue)
        {
            for (int i = 0; i <= ParamName.Length - 1; i++)
            {
                if (ParamName[i] != null)
                {
                    _cmd.Parameters.AddWithValue(ParamName[i], ParamValue[i]);
                }
            }
            return _cmd;
        }

        //string[] str = new string[] { "@type"};
        //object[] val = new object[] { 0 };
        //dt = dataconnect.ReadDataAddPram("sp_ReadAccount2", str, val, 100);
        public DataTable ReadDataAddPram(string sql, string[] ParamName, object[] ParamValue, int timeout)
        {
            Connect();
            Cmd = Connection.CreateCommand();
            Cmd.CommandType = CommandType.StoredProcedure;
            Cmd.CommandText = sql;
            Cmd.Connection = Connection;
            Cmd.CommandTimeout = timeout;
            Cmd = AddParameters(Cmd, ParamName, ParamValue);

            dataAp = new SqlDataAdapter(Cmd);
            DataSet ds = new DataSet();
            dataAp.Fill(ds);
            Cmd.Dispose();
            dataAp.Dispose();
            Disconnect();
            return ds.Tables[0];
        }


        //------------------------------------------------------------------------------
        //Program.cs
        static DataConnect dataconnect = new DataConnect();
        static void WriteAddParameterSQL()
        {
            string strSql;
            strSql = "insert into Account(uid, pass, type) values (@uid, @pass, @type)";

            Console.WriteLine("\nNhap uid: ");
            string uid = Console.ReadLine();

            Console.WriteLine("\nNhap pass: ");
            string pass = Console.ReadLine();

            Console.WriteLine("\nChon type: ");
            int type = int.Parse(Console.ReadLine());

            int result = dataconnect.ExcuteNonQuyery(CommandType.Text, strSql,
                new SqlParameter { ParameterName = "@uid", Value = uid },
                new SqlParameter { ParameterName = "@pass", Value = pass },
                new SqlParameter { ParameterName = "@type", Value = type });


        }


        //thuc hien cac ham them, xoa, sua tra ve tham so output
        static int WriteAddParameterSP()
        {
            string sp = "sp_ReadAccount";

            SqlParameter p = new SqlParameter("@j", SqlDbType.VarChar, 10);
            p.Direction = ParameterDirection.Output;

            dataconnect.ExcuteNonQuyery(CommandType.StoredProcedure, sp,
                new SqlParameter { ParameterName = "@type", Value = 1 }, p);

            return Convert.ToInt32(p.Value);

        }

        //foreach (DataRow row in dt.Rows)
        //{
        //      Console.WriteLine("\n\tUID: " + row["uid"] + ", pass: " + row["pass"] + ", type: " + row["type"]);
        //}
       
    }
}
