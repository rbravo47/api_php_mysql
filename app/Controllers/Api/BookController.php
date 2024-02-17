<?php

namespace App\Controllers\Api;

use App\Models\BookModel;
use CodeIgniter\RESTful\ResourceController;

class BookController extends ResourceController
{
    public function listBook()
	{
		$emp = new BookModel();
            
        //log_message('error', $e->getMessage());
        
		$response = [
			'status' => 200,
			"error" => false,
			'messages' => 'Book list',
			'data' => $emp->findAll()
		];

		return $this->respond($response);
	}


public function showBook($emp_id)
	{
		$emp = new BookModel();

		$data = $emp->find($emp_id);
        //$data = $model->where(['id' => $emp_id])->first();

		if (!empty($data)) {

			$response = [
				'status' => 200,
				"error" => false,
				'messages' => 'Single Book data',
				'data' => $data
			];

		} else {

			$response = [
				'status' => 500,
				"error" => true,
				'messages' => 'No Book found',
				'data' => []
			];
		}

		return $this->respond($response);
	}


public function updateBook($emp_id)
	{
		$rules = [
			"name" => "required",
			"email" => "required|valid_email|min_length[6]",
			"phone_no" => "required",
		];

		$messages = [
			"name" => [
				"required" => "Name is required"
			],
			"email" => [
				"required" => "Email required",
				"valid_email" => "Email address is not in format"
			],
			"phone_no" => [
				"required" => "Phone Number is required"
			],
		];

		if (!$this->validate($rules, $messages)) {

			$response = [
				'status' => 500,
				'error' => true,
				'message' => $this->validator->getErrors(),
				'data' => []
			];
		} else {

			$emp = new BookModel();

			if ($emp->find($emp_id)) {

				//Retrieving Raw Data (PUT, PATCH, DELETE)
				$input = $this->request->getRawInput();	
				$data['name'] = $input["name"];
				$data['email'] = $input["email"];
				$data['phone_no'] = $input["phone_no"];

				$emp->update($emp_id, $data);

				$response = [
					'status' => 200,
					'error' => false,
					'message' => 'Book updated successfully',
					'data' => []
				];
			}else {

				$response = [
					'status' => 500,
					"error" => true,
					'messages' => 'No Book found',
					'data' => []
				];
			}
		}

		return $this->respond($response);
	}

	public function deleteBook($emp_id)
	{
		$emp = new BookModel();

		$data = $emp->find($emp_id);

		if (!empty($data)) {

			$emp->delete($emp_id);

			$response = [
				'status' => 200,
				"error" => false,
				'messages' => 'Book deleted successfully',
				'data' => []
			];

		} else {

			$response = [
				'status' => 500,
				"error" => true,
				'messages' => 'No Book found',
				'data' => []
			];
		}

		return $this->respond($response);
	}

	public function addBook()
	{
		$rules = [
			"isbn" => "required",
			"title" => "required",
			"description" => "required",
			"autor" => "required",
		];

		$messages = [
				"isbn" => [
					"required" =>"isbn is required"		
				],
				"title" => [
					"required" =>"title is required"		
				],
				"description"=> [
					"required" =>"description is required"		
				],
				"autor"=> [
					"required" =>"autor is required"		
				]
			];

		if (!$this->validate($rules, $messages)) {

			$response = [
				'status' => 500,
				'error' => true,
				'message' => $this->validator->getErrors(),
				'data' => []
			];
		} else {

			$emp = new BookModel();

			$data['isbn'] = $this->request->getVar("isbn");
			$data['title'] = $this->request->getVar("title");
			$data['description'] = $this->request->getVar("description");
			$data['autor'] = $this->request->getVar("autor");

			$emp->save($data);

			$response = [
				'status' => 200,
				'error' => false,
				'message' => 'Book added successfully',
				'data' => []
			];
		}

		return $this->respond($response);
	}

}

