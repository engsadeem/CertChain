<?php

return [
    'etherscan_base_url' => env('ETHERSCAN_BASE_URL', 'https://sepolia.etherscan.io'),

    'network' => env('ETH_NETWORK', 'sepolia'),
    'network_name' => env('ETH_NETWORK_NAME', 'Sepolia Testnet'),
    'chain_id' => env('ETH_CHAIN_ID', '11155111'),

    'contract_address' => env('ETH_CONTRACT_ADDRESS'),
    'last_tx_hash' => env('ETH_LAST_TX_HASH'),

    'rpc_endpoint' => env('ETH_RPC_URL'),

    'private_key' => env('ETH_PRIVATE_KEY'),

    'confirmations' => (int) env('ETH_CONFIRMATIONS', 1),
    'certificate_id_type' => env('ETH_CERTIFICATE_ID_TYPE', 'uint256'),
    'register_function' => env('ETH_REGISTER_FUNCTION', 'registerCertificate'),
    'node_binary' => env('NODE_BINARY', 'node'),
];
