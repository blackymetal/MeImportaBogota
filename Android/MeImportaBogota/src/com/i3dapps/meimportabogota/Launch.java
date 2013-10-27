package com.i3dapps.meimportabogota;

import com.i3dapps.meimportabogota.services.ReporteWebService;

import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.Uri;
import android.os.Bundle;
import android.app.Activity;
import android.content.Context;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.VideoView;

public class Launch extends Activity implements LocationListener {

	LocationManager handle; // Gestor del servicio de localizaci�n
	private boolean servicioActivo;

	private Button botonActivar;
	private TextView longitud;
	private TextView latitud;
	private TextView proveedor;
	private String provider;

	// //////////CAMERA//////////////

	// Activity request codes
	private static final int CAMERA_CAPTURE_IMAGE_REQUEST_CODE = 100;
	private static final int CAMERA_CAPTURE_VIDEO_REQUEST_CODE = 200;
	public static final int MEDIA_TYPE_IMAGE = 1;
	public static final int MEDIA_TYPE_VIDEO = 2;

	// directory name to store captured images and videos
	private static final String IMAGE_DIRECTORY_NAME = "Hello Camera";

	private Uri fileUri; // file url to store image/video

	private ImageView imgPreview;
	private VideoView videoPreview;
	private Button btnCapturePicture, btnRecordVideo;

	// //////////CAMERA//////////////

	@Override
	public void onCreate(Bundle savedInstanceState) {

		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_launch);

		botonActivar = (Button) findViewById(R.id.BotonActivar);
		latitud = (TextView) findViewById(R.id.latitud);
		longitud = (TextView) findViewById(R.id.longitud);
		proveedor = (TextView) findViewById(R.id.proveedor);

		// El bot�n activar permitir� activar y desactivar el servicio.
		botonActivar.setOnClickListener(new View.OnClickListener() {
			public void onClick(View view) {
//				if (servicioActivo) {
//					pararServicio();
//				} else {
//					iniciarServicio();
//				}
				iniciarServicio();
			}
		});
	}

	public void pararServicio() {
		// Se para el servicio de localizaci�n
		servicioActivo = false;
		botonActivar.setText(R.string.activar);
		// Se desactivan las notificaciones
		handle.removeUpdates(this);
	}

	public void iniciarServicio() {
		// Se activa el servicio de localizaci�n
		servicioActivo = true;
		botonActivar.setText(R.string.desactivar);

		// Crea el objeto que gestiona las localizaciones
		handle = (LocationManager) getSystemService(Context.LOCATION_SERVICE);

		Criteria c = new Criteria();
		c.setAccuracy(Criteria.ACCURACY_FINE);
		// obtiene el mejor proveedor en funci�n del criterio asignado
		// (la mejor precisi�n posible)
		provider = handle.getBestProvider(c, true);
		proveedor.setText(provider);
		// Se activan las notificaciones de localizaci�n con los par�metros:
		// proveedor, tiempo m�nimo de actualizaci�n, distancia m�nima,
		// Locationlistener
		handle.requestLocationUpdates(provider, 10000, 1, this);
		// Obtenemos la �ltima posici�n conocida dada por el proveedor
		Location loc = handle.getLastKnownLocation(provider);
		muestraPosicionActual(loc);
		
		new ReporteWebService().execute("ADD_REPORT",
										"1",
										latitud.getText().toString(), 
										longitud.getText().toString(),
										imgPreview.toString(),
										"COMENTARIOS VARIOS");
										
										
		
		// Se desactivan las notificaciones
		handle.removeUpdates(this);
	}

	public void muestraPosicionActual(Location loc) {
		if (loc == null) {// Si no se encuentra localizaci�n, se mostrar�
							// "Desconocida"
			longitud.setText("Desconocida");
			latitud.setText("Desconocida");
		} else {// Si se encuentra, se mostrar� la latitud y longitud
			latitud.setText(String.valueOf(loc.getLatitude()));
			longitud.setText(String.valueOf(loc.getLongitude()));
		}
	}

	@Override
	public void onLocationChanged(Location location) {
		// Se ha encontrado una nueva localizaci�n
		muestraPosicionActual(location);
	}

	@Override
	public void onProviderDisabled(String provider) {
		// Proveedor deshabilitado
	}

	@Override
	public void onProviderEnabled(String provider) {
		// Proveedor habilitado
	}

	@Override
	public void onStatusChanged(String provider, int status, Bundle extras) {
		// Ha cambiado el estado del proveedor
	}

}
