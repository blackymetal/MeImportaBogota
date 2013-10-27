package com.i3dapps.meimportabogota.dao;

import android.content.Context;
import android.util.Log;

import com.i3dapps.meimportabogota.preferences.Preferencias;
import com.i3dapps.meimportabogota.services.IReportesWS;

public class Dao implements IReportesWS {
	
	Context context = null;
	String urlBase;

	public Dao(Context context) {
		this.context = context;
	}
	
	public String getUrlBase()
	{
		String urlBase = new Preferencias(context).getUrl(); 
		Log.d("listaCompras", "Url base: " + urlBase);
		return urlBase;
	}
	
	public void setUrlBase(String url)
	{
		this.urlBase = url;
	}

	@Override
	public void postReporte(String jsonListaCompra) {
		// TODO Auto-generated method stub

	}

	@Override
	public String getTiposDeReportes() {
		// TODO Auto-generated method stub
		return null;
	}

	@Override
	public String getReportePorTipo(int idLista) {
		// TODO Auto-generated method stub
		return null;
	}

}
