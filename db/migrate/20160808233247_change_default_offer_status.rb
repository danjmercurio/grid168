class ChangeDefaultOfferStatus < ActiveRecord::Migration
  def change
    change_column :offers, :status, :string, :default => 'Current'
  end
end
