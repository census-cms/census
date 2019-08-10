<?php
namespace CENSUS\Core\Module;


class User extends AbstractModule
{
	protected function initializeModule()
	{

	}

	private function getPasswordHash($password)
	{
		$config = $this->configuration['security']['password'];

		return password_hash($this->request->getArgument('password'), $config['algorithm'], $config['options']);
	}
}