package com.hustoj;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.List;

import android.os.Bundle;
import android.os.Handler;
import android.app.Activity;
import android.content.DialogInterface;
import android.content.DialogInterface.OnKeyListener;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;

import org.apache.http.*;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.protocol.HTTP;
import org.apache.http.util.EntityUtils;

public class MainActivity extends Activity {

	public Spinner spinner;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		Button btRun = (Button) findViewById(R.id.btRun);
		btRun.setOnClickListener(new RunCode(this));
	   spinner = (Spinner) findViewById(R.id.spLang);  
	        String[] m=new String[]{"C","C++","Pascal","Java","Ruby","Bash","Python","PHP","Perl","C#","Obj-C","FreeBasic"};
			//将可选内容与ArrayAdapter连接起来  
	        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,android.R.layout.simple_spinner_item,m);  
	          
	        //设置下拉列表的风格   
	        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);  
	          
	        //将adapter 添加到spinner中  
	        spinner.setAdapter(adapter);  
	          
	        //添加事件Spinner事件监听    
	        spinner.setOnItemSelectedListener(new SpinnerSelectedListener());  
	          
	        //设置默认值  
	        spinner.setVisibility(View.VISIBLE);  
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		getMenuInflater().inflate(R.menu.activity_main, menu);
		return true;
	}
}

class RunCode implements OnClickListener, Runnable {

	private MainActivity activity;
	private EditText source;
	private EditText console;
	private List<NameValuePair> params;
	private static Handler handler=new Handler();
	public RunCode(MainActivity mainActivity) {
		// TODO Auto-generated constructor stub
		this.activity = mainActivity;
		this.source = (EditText) activity.findViewById(R.id.editSource);
		this.console = (EditText) activity.findViewById(R.id.editConsole);

	}

	@Override
	public void onClick(View v) {
		int lang=this.activity.spinner.getSelectedItemPosition();
		params = new ArrayList<NameValuePair>();
		params.add(new BasicNameValuePair("problem_id", "0"));
		params.add(new BasicNameValuePair("language", String.valueOf(lang)));
		params.add(new BasicNameValuePair("source", source.getText().toString()));
		params.add(new BasicNameValuePair("input_text", console.getText()
				.toString()));
		new Thread(this).start();
	}

	private String httpPost(List<NameValuePair> params) {
		String ret = "";
		// "http://www.dubblogs.cc:8751/Android/Test/API/Post/index.php";
		String uriAPI = "http://hustoj.sinaapp.com/submit.php";
		/* 建立HTTP Post连线 */
		HttpPost httpRequest = new HttpPost(uriAPI);
		// Post运作传送变数必须用NameValuePair[]阵列储存
		// 传参数 服务端获取的方法为request.getParameter("name")

		try {

			// 发出HTTP request
			httpRequest.setEntity(new UrlEncodedFormEntity(params, HTTP.UTF_8));
			// 取得HTTP response
			HttpResponse httpResponse = new DefaultHttpClient()
					.execute(httpRequest);

			// 若状态码为200 ok
			if (httpResponse.getStatusLine().getStatusCode() == 200) {
				// 取出回应字串
				String strResult = EntityUtils.toString(httpResponse
						.getEntity());
				ret = (strResult);
			} else {
				ret = ("Error Response" + httpResponse.getStatusLine()
						.toString());
			}
		} catch (ClientProtocolException e) {
			ret = (e.getMessage().toString());
			e.printStackTrace();
		} catch (UnsupportedEncodingException e) {
			ret = (e.getMessage().toString());
			e.printStackTrace();
		} catch (IOException e) {
			ret = (e.getMessage().toString());
			e.printStackTrace();
		}
		return ret;
	}

	@Override
	public void run() {
		try {
			// TODO Auto-generated method stub
			String ret = httpPost(params);
			int sid = parseSID(ret);
			System.out.println(sid);
			String resultURL = "http://hustoj.sinaapp.com/status-ajax.php?solution_id="
					+sid;
			int result = 0;
			do {
				ret = HttpGet(resultURL);
				if (ret.indexOf(",") != -1) {
					String[] reta = ret.split(",");
					result = Integer.parseInt(reta[0]);
				}
				Thread.sleep(1000);
			} while (result < 4);
			
			String outURL = "http://hustoj.sinaapp.com/status-ajax.php?tr=&solution_id="
					+ sid;
			ret = HttpGet(outURL);
			handler.post(new Updater(activity,ret));
			
		} catch (Throwable t) {
			t.printStackTrace();
		}
	}

	private String HttpGet(String url) {
		HttpGet get = new HttpGet(url);
		HttpResponse httpResponse;
		String ret = "";
		try {
			httpResponse = new DefaultHttpClient().execute(get);
			if (httpResponse.getStatusLine().getStatusCode() == 200)
			// 判断请求响应状态码，状态码为200表示服务端成功响应了客户端的请求

			{
				try {
					ret = EntityUtils.toString(httpResponse.getEntity());
				} catch (ParseException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				} catch (IOException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				System.out.println(ret);
			}
		} catch (ClientProtocolException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		} catch (IOException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}

		return ret;
	}

	private int parseSID(String ret) {
		// TODO Auto-generated method stub
		if (ret != null) {
			int i = ret.indexOf("'");
			int j = ret.lastIndexOf("'");
			if (i != -1 && j != -1) {
				return Integer.parseInt(ret.substring(i + 1, j));
			}
		}
		return 0;
	}

}