using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Data.SqlClient;
using Microsoft.VisualBasic;
using System.Collections;
using System.Diagnostics;
using System.Xml;
using System.IO;
using System.Configuration;

namespace _1460130_QLPhongMachTu
{
    public partial class frmDSBenhNhan : Form
    {
        static DataConnect dp = new DataConnect();
        public frmDSBenhNhan()
        {
            InitializeComponent();
        }

        private void frmDSBenhNhan_Load(object sender, EventArgs e)
        {
            Loading();
        }

        private void Loading()
        {

            DataTable dt = new DataTable();
            string[] str = new string[] { "@Ngay" };
            object[] val = new object[] { "12/03/2017" };
            dt = dp.ReadDataAddPram("sp_ReadPhieuKhamBenh", str, val, 300);
            dgv.Rows.Clear();
            int i = 1;
            foreach (DataRow row in dt.Rows)
            {
                dgv.Rows.Add(i, row["HoTen"], row["NgayKham"], row["LoaiBenh"], row["TrieuChung"]);
                i++;
            }
           
        }
    }
}
