using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace _1460130_QLPhongMachTu
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void danhSáchKhámBệnhToolStripMenuItem_Click(object sender, EventArgs e)
        {
            frmDanhSachKhamBenh frm = new frmDanhSachKhamBenh();
            frm.Show();
        }

        private void phiếuKhámBệnhToolStripMenuItem_Click(object sender, EventArgs e)
        {
            frmPhieuKhamBenhNhanForm2 frm = new frmPhieuKhamBenhNhanForm2();
            frm.Show();
        }

        private void danhSáchBệnhNhânToolStripMenuItem_Click(object sender, EventArgs e)
        {

        }

        private void loạiBệnhToolStripMenuItem_Click(object sender, EventArgs e)
        {
            frm_LoaiBenh frm = new frm_LoaiBenh();
            frm.Show();
        }

        private void thuốcToolStripMenuItem_Click(object sender, EventArgs e)
        {
            frmThuoc frm = new frmThuoc();
            frm.Show();
        }

        private void đơnVịTínhToolStripMenuItem_Click(object sender, EventArgs e)
        {
            frmDonViTinh frm = new frmDonViTinh();
            frm.Show();
        }

        private void cáchDùngToolStripMenuItem_Click(object sender, EventArgs e)
        {
            frmCachDung frm = new frmCachDung();
            frm.Show();
        }

        private void hóaĐơnThanhToánToolStripMenuItem_Click(object sender, EventArgs e)
        {

        }

        private void báoCáoDoanhThuTheoNgàyToolStripMenuItem_Click(object sender, EventArgs e)
        {

        }

        private void báoCáoSửDụngThuốcToolStripMenuItem_Click(object sender, EventArgs e)
        {

        }

       
    }
}
