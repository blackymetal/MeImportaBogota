package com.i3dapps.meimportabogota;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;

import com.i3dapps.meimportabogota.services.ReporteWebService;

import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.Bitmap.CompressFormat;
import android.graphics.BitmapFactory;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;
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
	public static final int MEDIA_TYPE_IMAGE = 1;
	public static final int MEDIA_TYPE_VIDEO = 2;

	// directory name to store captured images and videos
	private static final String IMAGE_DIRECTORY_NAME = "Me Importa Bogota";

	private Uri fileUri; // file url to store image/video

	private ImageView imgPreview;
	private VideoView videoPreview;

	// //////////CAMERA//////////////

	@Override
	public void onCreate(Bundle savedInstanceState) {

		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_launch);

		botonActivar = (Button) findViewById(R.id.BotonActivar);
		latitud = (TextView) findViewById(R.id.latitud);
		longitud = (TextView) findViewById(R.id.longitud);
		proveedor = (TextView) findViewById(R.id.proveedor);
		ImageView imgPreview = (ImageView) findViewById(R.id.imgPreview);

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
		botonActivar.setText(R.string.registrar);
		// Se desactivan las notificaciones
		handle.removeUpdates(this);
	}

	public void iniciarServicio() {
		// Se activa el servicio de localizaci�n
		servicioActivo = true;
		//botonActivar.setText(R.string.desactivar);

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
		
		
		//CAMERA////////////////////////////////////////////////
		
		Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
		 
	    fileUri = getOutputMediaFileUri(MEDIA_TYPE_IMAGE);
	 
	    intent.putExtra(MediaStore.EXTRA_OUTPUT, fileUri);
	 
	    // start the image capture Intent
	    startActivityForResult(intent, CAMERA_CAPTURE_IMAGE_REQUEST_CODE);
	    
	    //CAMERA////////////////////////////////////////////////
	    
		/*new ReporteWebService().execute("ADD_REPORT",
										"1",
										latitud.getText().toString(), 
										longitud.getText().toString(),
										imgPreview.toString(),
										"COMENTARIOS VARIOS");*/
							
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
	
	/**
	 * Receiving activity result method will be called after closing the camera
	 * */
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
	    // if the result is capturing Image
	    if (requestCode == CAMERA_CAPTURE_IMAGE_REQUEST_CODE) {
	        if (resultCode == RESULT_OK) {
	            // successfully captured the image
	            // display it in image view
	            previewCapturedImage();
	        } else if (resultCode == RESULT_CANCELED) {
	            // user cancelled Image capture
	            Toast.makeText(getApplicationContext(),
	                    "User cancelled image capture", Toast.LENGTH_SHORT)
	                    .show();
	        } else {
	            // failed to capture image
	            Toast.makeText(getApplicationContext(),
	                    "Sorry! Failed to capture image", Toast.LENGTH_SHORT)
	                    .show();
	        }
	    }
	}
	
	/*
     * Display image from a path to ImageView
     */
    private void previewCapturedImage() {
        try {
            // hide video preview
            videoPreview.setVisibility(View.GONE);
 
            imgPreview.setVisibility(View.VISIBLE);
 
            // bimatp factory
            BitmapFactory.Options options = new BitmapFactory.Options();
 
            // downsizing image as it throws OutOfMemory Exception for larger
            // images
            options.inSampleSize = 8;
 
            final Bitmap bitmap = BitmapFactory.decodeFile(fileUri.getPath(),
                    options);
 
            imgPreview.setImageBitmap(bitmap);
        } catch (NullPointerException e) {
            e.printStackTrace();
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
	
	/**
	 * Creating file uri to store image/video
	 */
	public Uri getOutputMediaFileUri(int type) {
	    return Uri.fromFile(getOutputMediaFile(type));
	}
	 
	/*
	 * returning image / video
	 */
	private static File getOutputMediaFile(int type) {
	 
	    // External sdcard location
	    File mediaStorageDir = new File(
	            Environment
	                    .getExternalStoragePublicDirectory(Environment.DIRECTORY_PICTURES),
	            IMAGE_DIRECTORY_NAME);
	 
	    // Create the storage directory if it does not exist
	    if (!mediaStorageDir.exists()) {
	        if (!mediaStorageDir.mkdirs()) {
	            Log.d(IMAGE_DIRECTORY_NAME, "Oops! Failed create "
	                    + IMAGE_DIRECTORY_NAME + " directory");
	            return null;
	        }
	    }
	 
	    // Create a media file name
	    String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss",
	            Locale.getDefault()).format(new Date());
	    File mediaFile;
	    if (type == MEDIA_TYPE_IMAGE) {
	        mediaFile = new File(mediaStorageDir.getPath() + File.separator
	                + "IMG_" + timeStamp + ".jpg");
	    } else if (type == MEDIA_TYPE_VIDEO) {
	        mediaFile = new File(mediaStorageDir.getPath() + File.separator
	                + "VID_" + timeStamp + ".mp4");
	    } else {
	        return null;
	    }
	 
	    return mediaFile;
	}

}
