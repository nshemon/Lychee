<?php

namespace App\Actions\Diagnostics\Checks;

use App\Contracts\DiagnosticCheckInterface;
use App\Metadata\LycheeVersion;

class LycheeDBVersionCheck implements DiagnosticCheckInterface
{
	/**
	 * @var LycheeVersion
	 */
	private $lycheeVersion;

	/**
	 * @var array
	 */
	private $versions;

	/**
	 * @param LycheeVersion $lycheeVersion
	 * @param array caching the return of lycheeVersion->get()
	 */
	public function __construct(
		LycheeVersion $lycheeVersion
	) {
		$this->lycheeVersion = $lycheeVersion;

		$this->versions = $this->lycheeVersion->get();
	}

	public function check(array &$errors): void
	{
		if ($this->lycheeVersion->isRelease && $this->versions['DB']['version'] < $this->versions['Lychee']['version']) {
			$errors[] = 'Error: Database is behind file versions. Please apply the migration.';
		}
	}
}
