package com.i3dapps.meimportabogota.preferences;

import android.content.Context;
import android.content.SharedPreferences;


public class Preferencias {
	
	private static final String PREFS_NAME = "prefs";
	private Context context;
	
	public Preferencias(Context context)
	{
		this.context = context;
	}
	
	private String recuperarValor(String clave)
	{
		SharedPreferences settings = context.getSharedPreferences(PREFS_NAME, 0); 
		return settings.getString(clave, "http://127.0.0.1/MeImportaBogota/web/api/execute/");
	}
	
	private void salvarValor(String clave, String valor)
	{
		SharedPreferences settings = context.getSharedPreferences(PREFS_NAME, 0);
		SharedPreferences.Editor editor = settings.edit();
		editor.putString(clave,valor);
		editor.commit();
	}
	
	public String getUrl()
	{
		return recuperarValor("url");
	}
	
	public void saveUrl(String url)
	{
		salvarValor("url",url);
	}

}
