using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Xml;

namespace Tuan8
{
    class DataProvider
    {
        static string pathData = "hs.xml";
        static XmlDocument doc = null;
        static XmlNode nodeRoot = null;

        public static void OpenConnect()
        {
            if (doc == null)
                doc = new XmlDocument();

            doc.Load(pathData);
            nodeRoot = doc.DocumentElement;
        }

        public static void CloseConnect()
        {
            if (doc != null)
                doc.Save(pathData);
        }

        public static XmlNodeList GetDsNode(string xpath)
        {
            if (doc == null)
                OpenConnect();

            return nodeRoot.SelectNodes(xpath);
        }

        public static XmlNodeList GetDsNode(string xpath, XmlNode node)
        {
            return node.SelectNodes(xpath);
        }

        public static XmlNode GetNode(string xpath)
        {
            if (doc == null)
                OpenConnect();

            return nodeRoot.SelectSingleNode(xpath);
        }

        public static XmlNode GetNode(string xpath, XmlNode node)
        {
            return nodeRoot.SelectSingleNode(xpath);
        }

        public static XmlNode CreateNode(string tagName)
        {
            XmlNode node = doc.CreateElement(tagName);
            return node;
        }

        public static XmlAttribute CreateAtt(string name)
        {
            XmlAttribute att = doc.CreateAttribute(name);
            return att;
        }

    }
}
