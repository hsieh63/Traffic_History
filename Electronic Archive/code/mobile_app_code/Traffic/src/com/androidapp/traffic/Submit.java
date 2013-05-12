package com.androidapp.traffic;

import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.List;
import java.util.Locale;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.protocol.HTTP;

import android.app.Activity;
import android.content.Context;
import android.graphics.Color;
import android.graphics.Typeface;
import android.location.Address;
import android.location.Criteria;
import android.location.Geocoder;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.RadioButton;
import android.widget.TextView;
import android.widget.Toast;

public class Submit extends Activity implements LocationListener {

	RadioButton rb0;
	RadioButton rb1;
	RadioButton rb2;
	RadioButton rb3;
	RadioButton rb4;

	TextView title;
	Button b1;

	TextView tv;

	TextView latitude;
	TextView longitude;
	TextView address;
	TextView zip;

	LocationManager locationManager;
	String provider;

	double lat;
	double lng;

	String zipcode="";
	String street = "";
	int severity=1;
	String county = "County";
	String state = "";
	String shortDes = "REPORTED FROM MOBILE";

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.submit);

		rb0 = (RadioButton) findViewById(R.id.radio0);
		rb1 = (RadioButton) findViewById(R.id.radio1);
		rb2 = (RadioButton) findViewById(R.id.radio2);
		rb3 = (RadioButton) findViewById(R.id.radio3);
		rb4 = (RadioButton) findViewById(R.id.radio4);

		title = (TextView) findViewById(R.id.textView1);
		b1 = (Button) findViewById(R.id.button1);

		tv = (TextView) findViewById(R.id.stv);
		latitude = (TextView) findViewById(R.id.textView2);
		longitude = (TextView) findViewById(R.id.textView3);
		address = (TextView) findViewById(R.id.textView4);
		zip = (TextView) findViewById(R.id.textView5);

		Typeface clouds = Typeface.createFromAsset(getAssets(), "contm.ttf");

		title.setTypeface(clouds);
		b1.setTypeface(clouds);
		rb0.setTypeface(clouds);
		rb1.setTypeface(clouds);
		rb2.setTypeface(clouds);
		rb3.setTypeface(clouds);
		rb4.setTypeface(clouds);
		title.setTextColor(Color.WHITE);
		rb0.setTextColor(Color.WHITE);
		rb1.setTextColor(Color.WHITE);
		rb2.setTextColor(Color.WHITE);
		rb3.setTextColor(Color.WHITE);
		rb4.setTextColor(Color.WHITE);

		// Get the location manager
		locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
		// Define the criteria how to select the location provider -> use
		// default
		Criteria criteria = new Criteria();
		provider = locationManager.getBestProvider(criteria, true);
		Location location = locationManager.getLastKnownLocation(provider);

		// Initialize the location fields
		if (location != null) {
			System.out.println("Provider " + provider + " has been selected.");
			onLocationChanged(location);
		} else {
			//latitude.setText("Latitude not available");
			//longitude.setText("Longitude not available");
		}

		Geocoder geocoder = new Geocoder(this, Locale.ENGLISH);

		try {
			List<Address> addresses = geocoder.getFromLocation(lat, lng, 1);

			if ((addresses != null) & (addresses.size() > 0)) {
				Address returnedAddress = addresses.get(0);
				StringBuilder strReturnedAddress = new StringBuilder(
						"Address:\n");
				for (int i = 0; i < returnedAddress.getMaxAddressLineIndex(); i++) {
					strReturnedAddress
							.append(returnedAddress.getAddressLine(i)).append(
									"\n");
				}
				address.setText(strReturnedAddress.toString());
				String parse = strReturnedAddress.toString();
				int end = parse.length() - 1;
				zipcode = parse.substring(end - 5, end);
				state = parse.substring(end-8,end-6);
				int t1 = parse.indexOf("\n",0);
				int t2 = parse.indexOf("\n",t1+1);
				street = parse.substring(t1+1,t2);
				//zip.setText(zipcode);
			} else {
				//address.setText("No Address returned!");
			}
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			//address.setText("Cannot get Address!");
		}

	}

	public void submit(View v) {

		boolean a = rb0.isChecked();
		boolean b = rb1.isChecked();
		boolean c = rb2.isChecked();
		boolean d = rb3.isChecked();
		boolean e = rb4.isChecked();

		if (a == true) {
			// tv.setText("1");
			severity = 1;
		} else if (b == true) {
			// tv.setText("2");
			severity = 2;
		} else if (c == true) {
			// tv.setText("3");
			severity = 3;
		} else if (d == true) {
			// tv.setText("4");
			severity = 4;
		} else if (e == true) {
			// tv.setText("5");
			severity = 5;
		}
		// the below else is unnecessary?
		else {
			// tv.setText("1");
		}

		// to submit to the website, the keys to add to the params are, in
		// order:
		// zipcode, street, severity, county, state, shortDes, lat, long
		// where shortDes is a String of up to 50 characters describing the
		// incident
		// we can hardcode it to just be "MOBILE" for now, to show in the
		// database that
		// the traffic incident was reported from a phone

		String s1 = "";
		new submitReport().execute(s1, null, s1);

		/*
		 * try {
		 * 
		 * String sevPost = Integer.toString(severity); String latPost =
		 * Double.toString(lat); String lngPost = Double.toString(lng);
		 * 
		 * 
		 * HttpClient client = new DefaultHttpClient(); String postURL =
		 * "http://traffichistory.org/mobileReport.php"; HttpPost post = new
		 * HttpPost(postURL); List<NameValuePair> params = new
		 * ArrayList<NameValuePair>(); params.add(new
		 * BasicNameValuePair("zipcode", zipcode)); params.add(new
		 * BasicNameValuePair("street", street)); params.add(new
		 * BasicNameValuePair("severity", sevPost)); params.add(new
		 * BasicNameValuePair("county", county)); params.add(new
		 * BasicNameValuePair("state", state)); params.add(new
		 * BasicNameValuePair("shortDes", shortDes)); params.add(new
		 * BasicNameValuePair("lat", latPost)); params.add(new
		 * BasicNameValuePair("long", lngPost)); UrlEncodedFormEntity ent = new
		 * UrlEncodedFormEntity(params,HTTP.UTF_8); post.setEntity(ent);
		 * HttpResponse responsePOST = client.execute(post); HttpEntity
		 * resEntity = responsePOST.getEntity(); if (resEntity != null) {
		 * Log.i("RESPONSE",EntityUtils.toString(resEntity)); }
		 * 
		 * 
		 * InputStream is = resEntity.getContent();
		 * 
		 * byte[] data = new byte[256];
		 * 
		 * StringBuffer buffer = new StringBuffer(); int len = 0;
		 * 
		 * while (-1 != (len = is.read(data))) { buffer.append(new String(data,
		 * 0, len)); }
		 * 
		 * is.close();
		 * 
		 * String str = buffer.toString();
		 * 
		 * tv.setText(str);
		 * 
		 * 
		 * } catch (Exception e2) { e2.printStackTrace(); }
		 */

	}

	private class submitReport extends AsyncTask<String, Void, String> {

		private Exception exception;

		protected String doInBackground(String... strt) {

			try {

				String sevPost = Integer.toString(severity);
				String latPost = Double.toString(lat);
				String lngPost = Double.toString(lng);

				HttpClient client = new DefaultHttpClient();
				String postURL = "http://traffichistory.org/mobileReport.php";
				HttpPost post = new HttpPost(postURL);
				List<NameValuePair> params = new ArrayList<NameValuePair>();
				/*
				 * params.add(new BasicNameValuePair("zipcode", zipcode));
				 * params.add(new BasicNameValuePair("severity", sevPost));
				 * params.add(new BasicNameValuePair("street", street));
				 * params.add(new BasicNameValuePair("county", county));
				 * params.add(new BasicNameValuePair("state", state));
				 * params.add(new BasicNameValuePair("shortDes", shortDes));
				 * params.add(new BasicNameValuePair("lat", latPost));
				 * params.add(new BasicNameValuePair("long", lngPost));
				 */
				params.add(new BasicNameValuePair("zipcode", zipcode));
				params.add(new BasicNameValuePair("severity", sevPost));
				params.add(new BasicNameValuePair("street", street));
				params.add(new BasicNameValuePair("county", "Middlesex"));
				params.add(new BasicNameValuePair("state", state));
				params.add(new BasicNameValuePair("shortDes", shortDes));
				params.add(new BasicNameValuePair("lat", latPost));
				params.add(new BasicNameValuePair("long", lngPost));
				UrlEncodedFormEntity ent = new UrlEncodedFormEntity(params,
						HTTP.UTF_8);
				post.setEntity(ent);
				HttpResponse responsePOST = client.execute(post);
				HttpEntity resEntity = responsePOST.getEntity();
				if (resEntity != null) {
					// Log.i("RESPONSE",EntityUtils.toString(resEntity));
				}

				// resEntity = responsePOST.getEntity();

				InputStream is = resEntity.getContent();

				byte[] data = new byte[256];

				StringBuffer buffer = new StringBuffer();
				int len = 0;

				while (-1 != (len = is.read(data))) {
					buffer.append(new String(data, 0, len));
				}

				is.close();

				final String str = buffer.toString();

				runOnUiThread(new Runnable() {
					public void run() {
						// stuff that updates ui
						
							Toast.makeText(Submit.this,
					    	        str,
					    	        Toast.LENGTH_SHORT).show();
						
						
						//tv.setText(str);
					}
				});

			} catch (Exception e2) {
				e2.printStackTrace();
			}
			return strt.toString();
		}

		protected void onPostExecute(String url) {
			// TODO: check this.exception
			// TODO: do something with the feed
		}
	}

	/* Request updates at startup */
	@Override
	protected void onResume() {
		super.onResume();
		locationManager.requestLocationUpdates(provider, 400, 1, this);
	}

	/* Remove the locationlistener updates when Activity is paused */
	@Override
	protected void onPause() {
		super.onPause();
		locationManager.removeUpdates(this);
	}

	public void onLocationChanged(Location location) {
		lat = (location.getLatitude());
		lng = (location.getLongitude());
		//latitude.setText(String.valueOf(lat));
		//longitude.setText(String.valueOf(lng));
	}

	public void onStatusChanged(String provider, int status, Bundle extras) {
		// TODO Auto-generated method stub

	}

	public void onProviderEnabled(String provider) {
		Toast.makeText(this, "Enabled new provider " + provider,
				Toast.LENGTH_SHORT).show();

	}

	public void onProviderDisabled(String provider) {
		Toast.makeText(this, "Disabled provider " + provider,
				Toast.LENGTH_SHORT).show();
	}

}
